/****** Object:  StoredProcedure [dbo].[spRegrades]    Script Date: 2025/05/15 04:27:34 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
ALTER PROCEDURE [dbo].[spRegrades]
    -- Add the parameters for the stored procedure here
    @Reference AS NVARCHAR(15)
    , @CustomerName AS NVARCHAR(50)
    , @ProductNamee AS NVARCHAR(50)
    , @DepartmentName AS NVARCHAR(50)
    , @MachineName AS NVARCHAR(50)
    , @JobNo AS INTEGER
    , @ZincTested NVARCHAR(20)
    , @MPATested NVARCHAR(20)
    , @WireSizeTested AS NVARCHAR(20)
    , @Operator AS NVARCHAR(255)
    , @sequenceNo AS INT
    , @TensileTicket AS NVARCHAR(50)
    , @CustomerNamefrom AS NVARCHAR(50)
    , @ProductNamefrom AS NVARCHAR(50)
    , @intJobId AS BIGINT
    , @intBinId AS INT
    , @intUserId AS INT
AS
BEGIN
    -- SET NOCOUNT ON added to prevent extra result sets from
    -- interfering with SELECT statements.
    SET NOCOUNT ON;

    DECLARE @printer NVARCHAR(200)
    DECLARE @ActualWireSize AS FLOAT
    DECLARE @WireTol AS NVARCHAR(20)
    DECLARE @type AS NVARCHAR(5)
    DECLARE @dv AS NVARCHAR(10)
    DECLARE @mpaspec AS NVARCHAR(20)
    DECLARE @zincSpec AS NVARCHAR(20)
    DECLARE @RodSize AS NVARCHAR(20)
    DECLARE @RodSpec AS NVARCHAR(20)
    DECLARE @gas AS NVARCHAR(50)
    DECLARE @SECode AS NVARCHAR(50)
    DECLARE @WDBlackTol AS NVARCHAR(50)
    DECLARE @GalvRPM AS NVARCHAR(20)
    DECLARE @ReGradeRefNo AS INT
    DECLARE @TicketNo AS INT
    DECLARE @stringTicket AS NVARCHAR(10)
    DECLARE @ZincInitialMass AS INT
    DECLARE @ZincStripMass AS INT
    DECLARE @ZincStripSize AS FLOAT
    DECLARE @Weight AS NVARCHAR(20)
    DECLARE @GrossMass AS FLOAT
    DECLARE @taremass AS FLOAT
    DECLARE @RegradeRef AS NVARCHAR(50)
    DECLARE @oldtickno AS NVARCHAR(10)
    DECLARE @CastNo NVARCHAR(20)
    DECLARE @massProduced AS NVARCHAR(50)
    DECLARE @CurrentTest AS INT
    DECLARE @stresstest NVARCHAR(50)
    DECLARE @elongtest NVARCHAR(50)
    DECLARE @torsiontest NVARCHAR(50)
    DECLARE @wraptest NVARCHAR(50)
    DECLARE @coating NVARCHAR(50) -- this and above are for logging
    DECLARE @comment NVARCHAR(50)
    DECLARE @comments2 NVARCHAR(50)
    DECLARE @comments3 NVARCHAR(50)

    BEGIN TRY
        BEGIN TRANSACTION

        -- Insert statements for procedure here
        SELECT @ActualWireSize = WireSize
            , @WireTol = SizeTolerance
            , @type = [Type]
            , @dv = dv
            , @mpaspec = MPATolerance
            , @zincSpec = ZincSpec
            , @RodSize = RodSize
            , @RodSpec = RodType
            , @gas = Gas
            , @SECode = SECode
            , @WDBlackTol = WDBlackTol
            , @GalvRPM = GalvRPM
        FROM dbo.tblProductsWmax
        WHERE ProductName = @ProductNamee
            AND CustomerName = @CustomerName

        SELECT @ZincInitialMass = ZincInitialMass
            , @ZincStripMass = ZincStripMass
            , @ZincStripSize = ZincStripSize
            , @Weight = Weight
            , @GrossMass = GrossMass
            , @taremass = TareMass
            , @CastNo = CastNo
            , @oldtickno = TicketNo
        FROM dbo.tblRegradeJobs
        WHERE JobNo = @JobNo
            AND SequenceNo = @sequenceNo

        DECLARE @MyErrorMessage AS NVARCHAR(200)

        IF NOT EXISTS (
                SELECT *
                FROM tblReGradeRefNo
                )
        BEGIN
            INSERT INTO tblReGradeRefNo (ReGradeRefNo)
            VALUES (0)
        END

        UPDATE tblReGradeRefNo
        SET ReGradeRefNo = ReGradeRefNo + 1

        SELECT @RegradeRef = ReGradeRefNo
        FROM tblReGradeRefNo

        SELECT @TicketNo = max(isnull(TicketNo, 0)) + 1
        FROM dbo.tblTicketNo

        DELETE
        FROM dbo.tblTicketNo

        INSERT INTO dbo.tblTicketNo (TicketNo)
        VALUES (@TicketNo)

        SET @stringTicket = fORMAT(@TicketNo, '0000000')

        INSERT INTO dbo.tblCompletedJobs (
            DATETIME
            , Reference
            , JobNo
            , SequenceNo
            , Customer
            , Department
            , Machine
            , WireSize
            , ActualWireSize
            , WireTol
            , Type
            , DV
            , MPASpec
            , TreatedMPA
            , ZincSpec
            , TestedZinc
            , RodSize
            , RodSpec
            , CastNo
            , TensileTicket
            , Weight
            , ProductName
            , Gas
            , TicketNo
            , Regrade
            , OldTicketNo
            , RegradeRef
            , SECode
            , WDBlackTol
            , GalvRPM
            , ZincInitialMass
            , ZincStripMass
            , ZincStripSize
            , GrossMass
            , TareMass
            , Operator
            , Hold
            )
        VALUES (
            getdate()
            , @Reference
            , @JobNo
            , @sequenceNo
            , @CustomerName
            , @DepartmentName
            , @MachineName
            , @WireSizeTested
            , @ActualWireSize
            , @WireTol
            , @type
            , @dv
            , @mpaspec
            , @MPATested
            , @zincSpec
            , @ZincTested
            , @RodSize
            , @RodSpec
            , @CastNo
            , @TensileTicket
            , @Weight
            , @ProductNamee
            , @gas
            , @stringTicket
            , 'N'
            , @oldtickno
            , @RegradeRef
            , @SECode
            , @WDBlackTol
            , @GalvRPM
            , @ZincInitialMass
            , @ZincStripMass
            , @ZincStripSize
            , @GrossMass
            , @taremass
            , @Operator
            , 'RG'
            )

        SELECT @currenttest = TestNo
        FROM tblNewJobs
        WHERE JobNo = @JobNo

        SELECT @stresstest = intStressTest
            , @elongtest = intElongationAtBreak
            , @torsiontest = intTorsionTest
            , @wraptest = intOneDiameterWrapTest
            , @coating = strCoatingUniformity
            , @comment = Remarks
            , @comments2 = Remarks2
            , @comments3 = Remarks3
        FROM tblRegradeJobs
        WHERE JobNo = @JobNo
            AND SequenceNo = @sequenceNo

        SELECT @massProduced = [Weight]
        FROM tblCompletedJobs
        WHERE JobNo = @JobNo

        INSERT INTO tblGalvModuleLoggingConsole (
            intSequenceNo
            , intJobNo
            , intTestNumber
            , strStatusJob
            , strValueZinc
            , strValueMPA
            , strValueCast
            , strWireSize
            , strComment1
            , strZincInitialMass
            , strZincStripMass
            , strZincStripSize
            , strOperator
            , strComment2
            , strComment3
            , strValueStressTest
            , strValueElongTest
            , strValueTorsionTest
            , strValueDiameterTest
            , strValueUniformTest
            , strReferenceNo
            , strDepartment
            , strCustomerName
            , strProductName
            , strMachine
            , strValueTensileTicket
            , strValueTicket
            , strWeight
            , strGrossMass
            , strTearMass
            , strProducedMass
            , bitRegraded
            , strRegradeRef
            )
        VALUES (
            @sequenceNo
            , @JobNo
            , @CurrentTest
            , 'Regraded'
            , @ZincTested
            , @MPATested
            , @CastNo
            , @WireSizeTested
            , @comment
            , @ZincInitialMass
            , @ZincStripMass
            , @ZincStripSize
            , @Operator
            , @Comments2
            , @Comments3
            , @stresstest
            , @elongtest
            , @torsiontest
            , @wraptest
            , @coating
            , @reference
            , @DepartmentName
            , @CustomerName
            , @ProductNamee
            , @MachineName
            , @TensileTicket
            , @TicketNo
            , @Weight
            , @GrossMass
            , @taremass
            , @massProduced
            , 1
            , @RegradeRef
            )

        INSERT INTO tblGalvChecker (strChecker)
        VALUES ('NEWJOB')

        -- THIS PORTION ADDED FOR PRINTING DIRECTLY TO PRINTER LOGIC
        DECLARE @deptId AS INT
        DECLARE @deptname AS NVARCHAR(50)
        DECLARE @machinenId AS INT

        SELECT @deptId = intAutoID
        FROM tblDepartments
        WHERE strDeptName = @DepartmentName;

        SELECT @machinenId = intAutoMachineID
        FROM tblMachines
        WHERE strMachineName = @machinename;

        -- Added to track as a new printed label 20250213 ----------------------------------------------------------------------
        INSERT INTO [dbo].[tblJobQrcodeAllocation] (
            [strItemCode]
            , [intMachineId]
            , [intDeptId]
            , [intPalletId]
            , [mnyQtyRequired]
            , [strOperator]
            , [dteJobCreated]
            , [mnyEstimatedPallets]
            , [dteStartDate]
            , [strProductGroup]
            , [strProductCat]
            , [strCustomerName]
            , [strRef]
            , [strLabelType]
            , [mnyWeight]
            )
        VALUES (
            @SECode
            , @machinenId
            , @deptId
            , 1
            , 1
            , @Operator
            , getdate()
            , 1
            , cast(GETDATE() AS DATE)
            , ''
            , ''
            , @customerName
            , @reference
            , 'Single'
            , @Weight
            )

        DECLARE @intJobId AS INT

        SELECT @intJobId = @@IDENTITY
        FROM [tblJobQrcodeAllocation];

        UPDATE tblCompletedJobs
        SET intJobid = @intJobId
        WHERE TicketNo = @stringTicket

        -- Added to track as a new printed label 20250213 ----------------------------------------------------------------------

        -- Added 2025-05-14 for movements
        IF EXISTS (
                SELECT 1
                FROM tblJobQrcodeAllocation jobs
                LEFT OUTER JOIN tblSageFullStock stk
                    ON jobs.strItemCode = stk.Code
                WHERE jobs.intJobId = @intJobId
                    AND jobs.strItemCode IS NULL
                )
        BEGIN
            RAISERROR (
                    'Product not mapped to a valid Code in sage. Please contact your manager.'
                    , 16
                    , 1
                    );
        END

        IF EXISTS (
                SELECT intBinId
                FROM tblJobQrcodeAllocation jobs
                WHERE jobs.intJobId = @intJobId
                    AND jobs.intBinId IS NOT NULL
                )
        BEGIN
            INSERT INTO tblStockTransactionHistory (
                intBinId
                , intProductID
                , intDocType
                , intOwnerId
                , decSingleQuantity
                , decBundleQuantity
                , decPalletQuantity
                , decSingleWeight
                , decBundleWeight
                , decPalletWeight
                , dtmMovement
                , UserId
                , decAvgCost
                , decLastCost
                , intDocId
                , intLineId
                , strDocReference
                , strDocReference2
                )
            -- REMOVE FROM PREVIOUSLY KNOWN BIN
            SELECT jobs.intBinId
                , stk.StockLink
                , 3 -- Move From
                , 1 intOwnerId
                , - jobs.mnyEstimatedPallets decSingleQuantity
                , - IIF(jobs.strLabelType = 'Bundle', 1, 0) AS decBundleQuantity
                , - IIF(jobs.strLabelType = 'Pallet', 1, 0) AS decPalletQuantity
                , - ISNULL(jobs.mnyWeight / 1000, NULL) AS decSingleWeight -- This is going to track the single weight if its a weighted item
                , - IIF(jobs.strLabelType = 'Bundle', IIF(stk.ufIIWeight = 1, jobs.mnyWeight / 1000, NULL), NULL) AS decBundleWeight
                , - IIF(jobs.strLabelType = 'Pallet', IIF(stk.ufIIWeight = 1, jobs.mnyWeight / 1000, NULL), NULL) AS decPalletWeight
                , GETDATE()
                , @intUserId
                , NULL
                , NULL
                , @intJobId
                , @TicketNo
                , 'Regrade'
                , 'Stock Movement'
            FROM tblJobQrcodeAllocation jobs
            LEFT OUTER JOIN tblSageFullStock stk
                ON jobs.strItemCode = stk.Code
            WHERE jobs.intJobId = @intJobId
        END

        INSERT INTO tblStockTransactionHistory (
            intBinId
            , intProductID
            , intDocType
            , intOwnerId
            , decSingleQuantity
            , decBundleQuantity
            , decPalletQuantity
            , decSingleWeight
            , decBundleWeight
            , decPalletWeight
            , dtmMovement
            , UserId
            , decAvgCost
            , decLastCost
            , intDocId
            , intLineId
            , strDocReference
            , strDocReference2
            )
        -- ADD TO NEW BIN
        SELECT @intBinId
            , stk.StockLink
            , 2 -- Move To
            , 1 intOwnerId
            , jobs.mnyEstimatedPallets decSingleQuantity
            , IIF(jobs.strLabelType = 'Bundle', 1, 0) decBundleQuantity
            , IIF(jobs.strLabelType = 'Pallet', 1, 0) decPalletQuantity
            , ISNULL(jobs.mnyWeight / 1000, NULL) AS decSingleWeight
            , IIF(jobs.strLabelType = 'Bundle', IIF(stk.ufIIWeight = 1, jobs.mnyWeight / 1000, NULL), NULL) AS decBundleWeight
            , IIF(jobs.strLabelType = 'Pallet', IIF(stk.ufIIWeight = 1, jobs.mnyWeight / 1000, NULL), NULL) AS decPalletWeight
            , GETDATE()
            , @intUserId
            , NULL
            , NULL
            , @intJobId
            , @TicketNo
            , 'Regrade'
            , 'Stock Movement'
        FROM tblJobQrcodeAllocation jobs
        LEFT OUTER JOIN tblSageFullStock stk
            ON jobs.strItemCode = stk.Code
        WHERE jobs.intJobId = @intJobId

        UPDATE jobs
        SET intBinId = @intBinId
        FROM tblJobQrcodeAllocation jobs
        WHERE jobs.intJobId = @intJobId

        DELETE
        FROM dbo.tblRegradeJobs
        WHERE TicketNo = @oldtickno

        SELECT 'Success' Result
            , @CustomerName CustomerName
            , @ProductNamee ProductName
            , @stringTicket TicketNo
            , @oldtickno AS oldt

        COMMIT
    END TRY

    BEGIN CATCH
        IF @@TRANCOUNT > 0
            ROLLBACK

        SELECT ERROR_MESSAGE() AS Result
    END CATCH
END
