SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Kyle Westran
-- Create date: 2023-05-02
-- Description:	Updates the roofing Planned Lines

ALTER PROCEDURE [dbo].[spUpdateRoofLines]
	-- Add the parameters for the stored procedure here
	@xml as xml,
	@userName as nvarchar(50),
	@userId as int,
	@batchId as int,
	@batchReference as nvarchar(50)
	
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from interfering with SELECT statements.
	SET NOCOUNT ON;

	DECLARE @jobQrcodeOD AS BIGINT
	DECLARE @intDeptId AS BIGINT
	DECLARE @mnyEstimatedPallets AS MONEY =1
	DECLARE @count AS INT 
	DECLARE @deptname AS NVARCHAR(50)
	DECLARE @prodname AS NVARCHAR(50)
	DECLARE @productCategory AS NVARCHAR(50)
	DECLARE @deptId AS INT
	DECLARE @orderlineId INT
	DECLARE @qty AS MONEY
	DECLARE @soNum AS NVARCHAR(50)
	DECLARE @jobSeq AS INT
	DECLARE @UniqueID AS INT
	DECLARE @machinename AS NVARCHAR(50)
	DECLARE @customerName AS NVARCHAR(250)
	DECLARE @reference AS NVARCHAR(50)
	DECLARE @type AS INT
	DECLARE @machine AS NVARCHAR(50)
	DECLARE @machineId AS INT
    DECLARE @qtyCheck AS MONEY
	DECLARE @intConfiguration AS MONEY

    INSERT INTO tblXmldata(strXML) VALUES(@xml)
    
    BEGIN TRY 
        BEGIN TRANSACTION

        DECLARE db_cursor CURSOR FOR 

        SELECT
            soNum = XTbl.value('(soNum)[1]', 'nvarchar(50)'),
            prodname = XTbl.value('(prodname)[1]', 'nvarchar(50)'),
            productCategory = XTbl.value('(productcategory)[1]', 'nvarchar(50)'),
            deptname = XTbl.value('(department)[1]', 'nvarchar(50)'),
            orderlineId = XTbl.value('(orderLineId)[1]', 'int'),
            intConfiguration = XTbl.value('(intConfiguration)[1]', 'money'),
            qty = XTbl.value('(intQty)[1]', 'money'),
            machine = XTbl.value('(intAutoMachineID)[1]', 'nvarchar(50)'),
            jobSeq = XTbl.value('(jobSeq)[1]', 'int'),
            UniqueID = XTbl.value('(UniqueID)[1]', 'int')
        FROM 
            @xml.nodes('/xml/result') AS x(XTbl)

        OPEN db_cursor  
        FETCH NEXT FROM db_cursor INTO @soNum,@prodname,@productCategory,@deptname,@orderlineId,@intConfiguration,@qty,@machineId,@jobSeq,@UniqueID

        WHILE @@FETCH_STATUS = 0  
        
        BEGIN  
            SELECT @qtyCheck = intQty FROM tblRoofingSONumToPlan WHERE intRoofingHeader = @batchId AND intRoofSOID = @UniqueID
            
            UPDATE tblRoofingSONumToPlan 
            SET intMachineId = @machineId, 
                intConfiguration = @intConfiguration, 
                intQty = @qty,
                intSequence = @jobSeq, 
                dtmUpdated = GETDATE(), 
                strJobStatus = CASE WHEN @qty <> @qtyCheck THEN NULL ELSE strJobStatus END
            WHERE intRoofingHeader = @batchId AND intRoofSOID = @UniqueID
        
            FETCH NEXT FROM db_cursor INTO @soNum,@prodname,@productCategory,@deptname,@orderlineId,@intConfiguration,@qty,@machineId,@jobSeq,@UniqueID
        END 
       
        CLOSE db_cursor  
        DEALLOCATE db_cursor 
        SELECT 'Success' Result

        COMMIT 
    END TRY 

    BEGIN CATCH 
        IF @@TRANCOUNT > 0 
            ROLLBACK

        SELECT  ( ERROR_MESSAGE() ) as Result
    END CATCH 
END
GO
