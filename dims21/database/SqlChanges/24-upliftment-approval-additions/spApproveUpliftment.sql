/****** Object:  StoredProcedure [dbo].[spApproveUpliftment]    Script Date: 2025/06/17 00:00:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author: Robin Baillie
-- Update: (2025/03/31) Johnson - Changes for Making Sure 2 or more User has to Approve An Upliftment
-- Update: (2025/06/17) Kyle - Respond with Approval number for Frontend Response
-- Description: Approves the upliftment to make it available for the picking planner
-- Requires at least 2 distinct user approvals
-- =============================================
ALTER PROCEDURE [dbo].[spApproveUpliftment] 
    @upliftmentnumber INT
    , @userid INT
    , @bitHandingFee BIT --Johnson Changes (2025/03/31)
    , @strComment NVARCHAR(MAX) --Johnson Changes (2025/03/31)
AS
BEGIN
    SET NOCOUNT ON;

    -- Email Notification Setup (unchanged)
    DECLARE @Recipient NVARCHAR(100)
    DECLARE @CreatorId INT
    DECLARE @SendList NVARCHAR(500)
    DECLARE @ApprovedBy NVARCHAR(50)

    DECLARE @Status INT = 1;
    DECLARE @Message NVARCHAR(255);

    BEGIN TRY
        BEGIN TRANSACTION;

        SELECT @ApprovedBy = UserName
        FROM tblDIMSUSERS
        WHERE UserID = @userid

        SELECT @Recipient = u.Email
            , @CreatorId = u.UserID
        FROM tblUpliftmentHeaders uh
        INNER JOIN tblDIMSUSERS u
            ON u.UserID = uh.intUserID
        WHERE uh.intUpliftmentNumber = @upliftmentnumber

        SELECT @SendList = STRING_AGG(emails.strEmail + ',', '') + @Recipient
        FROM (
            SELECT DISTINCT strEmail
            FROM viewEmailReportRecipients
            WHERE strType = 'Approve Upliftment'
                AND strEmail <> @Recipient
        ) AS emails

        -- Only proceed if upliftment is not already finalized
        IF NOT EXISTS (
            SELECT 1
            FROM tblUpliftmentHeaders
            WHERE intUpliftmentNumber = @upliftmentnumber
                AND strUpliftmentStatus IN ('Denied', 'Completed', 'Printed')
        )   
        BEGIN
            -- Stop approval process if the user has already approved the upliftment
            IF EXISTS (
                SELECT 1
                FROM tblApproveUpliftment
                WHERE userid = @userid
                    AND intupliftmentnumber = @upliftmentnumber
            )
            BEGIN
                RAISERROR('You have already approved the upliftment.', 16, 1);
                RETURN;
            END

            INSERT INTO tblApproveUpliftment (
                userid
                , intupliftmentnumber
                , bitApproved
                , strComment
                , dtmApproved
            )
            VALUES (
                @userid
                , @upliftmentnumber
                , 1
                , @strComment
                , GETDATE()
            );

            UPDATE tblUpliftmentHeaders
            SET bitHandingFee = @bitHandingFee
            WHERE intUpliftmentNumber = @upliftmentnumber;

            -- Count number of unique users who approved Johnson Changes (2025/03/31)
            DECLARE @approvalCount INT;

            SELECT @approvalCount = COUNT(DISTINCT userid)
            FROM tblApproveUpliftment
            WHERE intupliftmentnumber = @upliftmentnumber
                AND bitApproved = 1;

            -- Approve the upliftment if at least 2 users approved Johnson Changes (2025/03/31)
            IF @approvalCount >= 2
            BEGIN
                UPDATE tblUpliftmentHeaders
                SET strUpliftmentStatus = 'Approved'
                    , bitHandingFee = @bitHandingFee
                WHERE intUpliftmentNumber = @upliftmentnumber;

                -- Log approval action
                INSERT INTO tblUpliftmentBacklog (
                    strMessage
                    , intUserID
                    , intUpliftmentNumber
                    )
                VALUES (
                    'Upliftment Approved'
                    , @userid
                    , @upliftmentnumber
                    );
                SET @Message = '2nd upliftment approved.';
            END
            ELSE
            BEGIN
                SET @Message = '1st upliftment approved. Waiting for 2nd approval.';
            END

            DECLARE @company NVARCHAR(50) = (
                SELECT strCompany
                FROM tblUpliftmentHeaders
                WHERE intUpliftmentNumber = @upliftmentnumber
            )
            DECLARE @client NVARCHAR(50) = (
                SELECT strCustomer
                FROM tblUpliftmentHeaders
                WHERE intUpliftmentNumber = @upliftmentnumber
            )
            DECLARE @area NVARCHAR(50) = (
                SELECT strArea
                FROM tblUpliftmentHeaders
                WHERE intUpliftmentNumber = @upliftmentnumber
            )

            INSERT INTO tblCommunications (
                SendTo,
                Subject,
                Type,
                Body,
                DealtWith
            )
            VALUES (
                @SendList,
                'Approved Upliftment UPL#' + RIGHT('000000' + CAST(@upliftmentnumber AS VARCHAR(6)), 6),
                'HTMLEmail',
                '<html>
                    <body>
                        <p>The following upliftment UPL#' + RIGHT('000000' + CAST(@upliftmentnumber AS VARCHAR(6)), 6) + 
                        ' was approved by ' + @ApprovedBy + ' ' + 
                        CASE 
                            WHEN @bitHandingFee = 1 THEN 'with a 10% handling fee.'
                            ELSE 'without handling fee.'
                        END + '</p>
                        <p><strong>' + 
                        CASE 
                            WHEN @approvalCount = 1 THEN '1st upliftment approved. Waiting for 2nd approval.'
                            WHEN @approvalCount = 2 THEN '2nd upliftment approved.'
                            ELSE ''
                        END + '</strong></p>
                        <ul>
                            <li>Company: ' + @company + '</li>
                            <li>Client: ' + @client + '</li>
                            <li>Area: ' + @area + '</li>
                        </ul>
                        <p><strong>Comment:</strong> ' + @strComment + '</p>
                        <p>Regards,</p>
                        <p>Hendok DIMS</p>
                    </body>
                </html>',
                0
            )
        END

        COMMIT TRANSACTION;
    END TRY

    BEGIN CATCH
        ROLLBACK TRANSACTION;

        SET @Status = 0;
        SET @Message = ERROR_MESSAGE();
    END CATCH;
    
    SELECT @Status AS [Status], @Message AS [Message];
END