SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
ALTER procEDURE [dbo].[spWeighAcceptHold] 
	-- Add the parameters for the stored procedure here
	@Reference as nvarchar(15),
	@CustomerName as nvarchar(50),
	@ProductNamee as nvarchar(50),
	@DepartmentName as nvarchar(50),
	@MachineName  as nvarchar(50),
	@JobNo as integer,
	@MassProduce as float,					
	@ZincTested nvarchar(20),
	@MPATested nvarchar(20),
	@CastNo nvarchar(20),					
	@WireSizeTested as float,
	@LTestPass_Fail as nvarchar(255)='P',	
	@Operator as nvarchar(255),
	@sequenceNo as int,
	@TensileTicket as nvarchar(50),
	@Weight as float,
	@GrossMass as float,
	@taremass as float,
	@buttonMethod as nvarchar(50)

AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;
	DECLARE @printer nvarchar(200)
	DECLARE @ActualWireSize as float
	DECLARE @WireTol as nvarchar(20)
	DECLARE @type as nvarchar(5)
	DECLARE @dv as nvarchar(10)
	DECLARE @mpaspec as nvarchar(20)
	DECLARE @zincSpec as nvarchar(20)
	DECLARE @RodSize as nvarchar(20)
	DECLARE @RodSpec as nvarchar(20)
	DECLARE @gas as nvarchar(50)
	DECLARE @SECode as nvarchar(50)
	DECLARE @WDBlackTol as nvarchar(50)
	DECLARE @GalvRPM as nvarchar(20)
	DECLARE @comment as nvarchar(255)
	DECLARE @Comments2 as nvarchar(255)		 
	DECLARE @Comments3 as nvarchar(255)	
	DECLARE @ZincInitialMass as int
	DECLARE @ZincStripMass as int
	DECLARE @ZincStripSize as float
	DECLARE @TicketNo as int
	DECLARE @stringTicket as nvarchar(10)
    DECLARE @CurrentTest as int
    DECLARE @stresstest nvarchar(50)
    DECLARE @elongtest nvarchar(50)
    DECLARE @torsiontest nvarchar(50)
    DECLARE @wraptest nvarchar(50)
    DECLARE @coating nvarchar(50) -- this and above are for logging
	DECLARE @checkForTicketNo nvarchar(50)
	DECLARE @latestTicketNo nvarchar(50)
    -- Insert statements for procedure here

    -- SELECT THE PRODUCT INFORMATION
	SELECT 
        @ActualWireSize = WireSize, 
        @WireTol = SizeTolerance, 
        @type = [Type], 
        @dv = dv,
        @mpaspec = MPATolerance, 
        @zincSpec = ZincSpec,
        @RodSize = RodSize, 
        @RodSpec = RodType,
        @gas = Gas,
        @SECode = SECode,
        @WDBlackTol = WDBlackTol,
	    @GalvRPM = GalvRPM
	FROM linxdbdimsHendok.dbo.tblProductsWmax 
    WHERE ProductName = @ProductNamee AND CustomerName = @CustomerName

    -- SELECT JOB INFORMATION
	SELECT 
        @comment = Remarks, 
        @Comments2 = Remarks2, 
        @Comments3 = Remarks3, 
        @ZincInitialMass = ZincInitialMass, 
	    @ZincStripMass = ZincStripMass,
        @ZincStripSize = ZincStripSize
	FROM linxdbdimsHendok.dbo.tblPendingJobs 
    WHERE JobNo = @JobNo AND Reference = @Reference AND CustomerName = @CustomerName AND DepartmentName = @DepartmentName AND MachineName = @MachineName AND ProductName = @ProductNamee AND @sequenceNo = SeqNo

    -- SELECT THE TICKET NUMBER
	SELECT @TicketNo = max(isnull(TicketNo,0))+1 
    FROM linxdbdimsHendok.dbo.tblTicketNo 

    -- UPDATE LATEST TICKET NUMBER
	DELETE FROM  linxdbdimsHendok.dbo.tblTicketNo
	INSERT INTO  linxdbdimsHendok.dbo.tblTicketNo (TicketNo) VALUES (@TicketNo)

	
	SET @stringTicket = fORMAT(@TicketNo,'0000000')


	-- Added check for duplicate ticket number
	IF EXISTS(SELECT 1 FROM tblCompletedJobs WHERE TicketNo = @stringTicket)
	BEGIN
		SELECT @TicketNo = cast(MAX(TicketNo) as int)+1 FROM tblCompletedJobs

        DELETE FROM  tblTicketNo
	    INSERT INTO  tblTicketNo (TicketNo) VALUES (@TicketNo)

        SET @stringTicket = fORMAT(@TicketNo,'0000000')
    END

	BEGIN TRY 
        BEGIN TRANSACTION

        DECLARE @MyErrorMessage as nvarchar(200)

        -- IF THE JOB IS ACCEPTED
        IF @buttonMethod = 'ACCEPT'
        BEGIN
            
            INSERT INTO tblGalvChecker (strChecker) VALUES ('NEWJOB')

            -- INSERT THE ACCEPTED JOB
            INSERT INTO linxdbdimsHendok.dbo.tblCompletedJobs 
            (
                DateTime, JobNo, SequenceNo, Reference, Customer, Department, Machine, WireSize, ActualWireSize, WireTol, Type, DV, MPASpec, TreatedMPA, ZincSpec, TestedZinc, RodSize, RodSpec, CastNo, TensileTicket, Weight, ProductName, Gas, TicketNo, Regrade, SECode, WDBlackTol, GalvRPM, Operator, ZincInitialMass, ZincStripMass, ZincStripSize, GrossMass, TareMass, Remarks, Remarks2, Remarks3
            )
            VALUES 
            ( 
                getdate(), @JobNo, @sequenceNo, @Reference, @CustomerName, @DepartmentName, @MachineName, @WireSizeTested, @ActualWireSize, @WireTol, @type, @dv, @mpaspec, @MPATested, @zincSpec, @ZincTested, @RodSize, @RodSpec, @CastNo, @TensileTicket, @Weight, @ProductNamee, @gas, @stringTicket, 'N', @SECode, @WDBlackTol, @GalvRPM, @Operator, @ZincInitialMass, @ZincStripMass, @ZincStripSize, @GrossMass, @taremass, @comment, @Comments2, @Comments3
            )
            
            DECLARE @checkerMass int 
            DECLARE @requiredMass int

            UPDATE tblNewJobs 
            SET MassProduced = isnull(MassProduced, 0) + @MassProduce
            WHERE JobNo = @JobNo AND Reference = @Reference AND CustomerName = @CustomerName AND 
            DepartmentName = @DepartmentName AND MachineName = @MachineName AND ProductName =@ProductNamee 

            UPDATE tblQCPhase1 
            SET MassProduced = isnull(MassProduced, 0) + @MassProduce
            WHERE JobNo = @JobNo AND Reference = @Reference AND CustomerName = @CustomerName AND 
            DepartmentName = @DepartmentName AND MachineName = @MachineName AND ProductName =@ProductNamee
            
            SET @currentTest = (SELECT TestNo FROM tblNewJobs WHERE JobNo = @JobNo)
                
            SELECT 
                @stresstest = intStressTest, 
                @elongtest = intElongationAtBreak, 
                @torsiontest = intTorsionTest, 
                @wraptest = intOneDiameterWrapTest,
                @coating = strCoatingUniformity 
            FROM tblPendingJobs WHERE JobNo = @JobNo AND Reference = @Reference AND CustomerName = @CustomerName AND DepartmentName = @DepartmentName AND MachineName = @MachineName AND ProductName =@ProductNamee and SeqNo = @sequenceNo

            INSERT INTO tblGalvModuleLoggingConsole
            ( 
                intSequenceNo, intJobNo, intTestNumber, strStatusJob, strValueZinc, strValueMPA, strValueCast, strWireSize, strComment1, strZincInitialMass, strZincStripMass, strZincStripSize, strOperator, strComment2, strComment3, strValueStressTest, strValueElongTest, strValueTorsionTest, strValueDiameterTest, strValueUniformTest, strReferenceNo, strDepartment, strCustomerName, strProductName, strMachine, strValueTensileTicket, strValueTicket, strWeight, strGrossMass, strTearMass, strProducedMass
            )
            VALUES
            (
                @sequenceNo, @JobNo, @CurrentTest, @buttonMethod, @ZincTested, @MPATested, @CastNo, @WireSizeTested, @comment, @ZincInitialMass, @ZincStripMass, @ZincStripSize, @Operator, @Comments2, @Comments3, @stresstest, @elongtest, @torsiontest, @wraptest, @coating, @reference, @DepartmentName,@CustomerName, @ProductNamee, @MachineName, @TensileTicket, @TicketNo, @Weight, @GrossMass, @taremass, @checkerMass
            )
        END

        UPDATE linxdbdimsHendok.dbo.tblPendingJobs 
        SET Weighed = 'Y' 
        WHERE JobNo = @JobNo AND Reference = @Reference AND CustomerName = @CustomerName AND DepartmentName = @DepartmentName AND MachineName = @MachineName AND ProductName =@ProductNamee AND SeqNo = @sequenceNo

        -- IF THE JOB IS HELD
        IF @buttonMethod = 'HOLD'
        BEGIN

            INSERT INTO tblGalvChecker (strChecker) VALUES ('REGRADE')
            INSERT INTO tblGalvChecker (strChecker) VALUES ('NEWJOB')
            
            INSERT INTO linxdbdimsHendok.dbo.tblCompletedJobs 
            (
                DateTime, JobNo, SequenceNo, Reference, Customer, Department, Machine, WireSize, ActualWireSize, WireTol, Type, DV, MPASpec, TreatedMPA,ZincSpec, TestedZinc, RodSize, RodSpec, CastNo, TensileTicket, Weight, ProductName, Gas, TicketNo, Regrade, SECode, WDBlackTol, GalvRPM,Operator, Hold, ZincInitialMass, ZincStripMass, ZincStripSize, GrossMass, TareMass, Remarks, Remarks2, Remarks3
            ) 
            VALUES
            (
                getdate(), @JobNo, @sequenceNo, @Reference, @CustomerName, @DepartmentName, @MachineName, @WireSizeTested, @ActualWireSize, @WireTol, @type,@dv, @mpaspec, @MPATested, @zincSpec, @ZincTested, @RodSize, @RodSpec, @CastNo, @TensileTicket, @Weight, @ProductNamee, @gas, @stringTicket,'Y', @SECode, @WDBlackTol, @GalvRPM, @Operator, 'Hold', @ZincInitialMass, @ZincStripMass, @ZincStripSize, @GrossMass, @taremass, @comment,@Comments2, @Comments3
            )	

            UPDATE linxdbdimsHendok.dbo.tblPendingJobs 
            SET Weighed = 'Y' 
            WHERE JobNo = @JobNo AND Reference = @Reference AND CustomerName = @CustomerName AND DepartmentName = @DepartmentName AND MachineName = @MachineName AND ProductName =@ProductNamee  and SeqNo = @sequenceNo
        
            UPDATE tblQCPhase1 
            SET MassProduced = 0 + @MassProduce
            WHERE JobNo = @JobNo AND Reference = @Reference AND CustomerName = @CustomerName AND DepartmentName = @DepartmentName AND MachineName = @MachineName AND ProductName =@ProductNamee

            SET @CurrentTest  = (SELECT TestNo FROM tblNewJobs WHERE JobNo = @JobNo)

            SELECT 
                @stresstest = intStressTest, 
                @elongtest = intElongationAtBreak, 
                @torsiontest = intTorsionTest, 
                @wraptest = intOneDiameterWrapTest,
                @coating = strCoatingUniformity 
            from tblPendingJobs WHERE JobNo = @JobNo AND Reference = @Reference AND CustomerName = @CustomerName AND DepartmentName = @DepartmentName AND MachineName = @MachineName AND ProductName =@ProductNamee and SeqNo = @sequenceNo

            INSERT INTO linxdbdimsHendok.dbo.tblRegradeJobs 
            (
                DateTime, JobNo, SequenceNo, Reference, Customer, Department, Machine, WireSize, ActualWireSize, WireTol, Type, DV, MPASpec, TreatedMPA,ZincSpec, TestedZinc, RodSize, RodSpec, CastNo, TensileTicket, Weight, ProductName, Gas, TicketNo, SECode, WDBlackTol, GalvRPM,ZincInitialMass, ZincStripMass, ZincStripSize, GrossMass, TareMass, Operator, Remarks, Remarks2, Remarks3, intSeq, intStressTest,intElongationAtBreak, intTorsionTest, intOneDiameterWrapTest, strCoatingUniformity, dtePassTime
            ) 
            VALUES 
            (
                getdate(), @JobNo, @sequenceNo, @Reference, @CustomerName, @DepartmentName, @MachineName, @WireSizeTested, @ActualWireSize, @WireTol, @type, @dv, @mpaspec, @MPATested, @zincSpec, @ZincTested, @RodSize, @RodSpec, @CastNo, @TensileTicket, @Weight, @ProductNamee, @gas, @stringTicket, @SECode, @WDBlackTol, @GalvRPM, @ZincInitialMass, @ZincStripMass, @ZincStripSize, @GrossMass, @taremass, @Operator, @comment, @Comments2, @Comments3, @sequenceNo, @stresstest, @elongtest, @torsiontest, @wraptest, @coating, getdate()
            )

            INSERT INTO tblGalvModuleLoggingConsole
            ( 
                intSequenceNo, intJobNo, intTestNumber, strStatusJob, strValueZinc, strValueMPA, strValueCast, strWireSize, strComment1, strZincInitialMass, strZincStripMass, strZincStripSize, strOperator, strComment2, strComment3, strValueStressTest, strValueElongTest, strValueTorsionTest, strValueDiameterTest, strValueUniformTest, strReferenceNo, strDepartment, strCustomerName, strProductName, strMachine, strValueTensileTicket, strValueTicket, strWeight, strGrossMass, strTearMass, strProducedMass
            )
            values
            (
                @sequenceNo, @JobNo, @CurrentTest, @buttonMethod, @ZincTested, @MPATested, @CastNo, @WireSizeTested, @comment, @ZincInitialMass, @ZincStripMass, @ZincStripSize, @Operator, @Comments2, @Comments3, @stresstest, @elongtest, @torsiontest, @wraptest, @coating, @reference, @DepartmentName, @CustomerName, @ProductNamee, @MachineName, @TensileTicket, @TicketNo, @Weight, @GrossMass, @taremass, @checkerMass
            )
        END

        -- THIS PORTION ADDED FOR PRINTING DIRECTLY TO PRINTER LOGIC
        DECLARE @deptId AS INT
        DECLARE @machinenId AS INT

        SELECT @deptId = intAutoID
        FROM tblDepartments
        WHERE strDeptName = @departmentName;
        
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
        SELECT @intJobId = @@IDENTITY FROM [tblJobQrcodeAllocation];

        UPDATE tblCompletedJobs SET intJobid = @intJobId WHERE TicketNo = @stringTicket
        
        UPDATE tblRegradeJobs SET intJobid = @intJobId WHERE TicketNo = @stringTicket -- Added 20250514 to track location of coil
        
        -- Added to track as a new printed label 20250213 ----------------------------------------------------------------------
        
        SELECT 'Success' Result, @CustomerName CustomerName, @ProductNamee ProductName, @stringTicket TicketNo
        COMMIT

    END TRY 

    BEGIN catch 
        IF @@TRANCOUNT > 0 
            ROLLBACK 
            SELECT  ERROR_MESSAGE() AS Result, @CustomerName CustomerName, @ProductNamee ProductName, @stringTicket TicketNo
        END catch 
    END

GO
