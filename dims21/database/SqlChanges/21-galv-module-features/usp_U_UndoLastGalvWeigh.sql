SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- Create the stored procedure in the specified schema
ALTER PROCEDURE [dbo].[usp_U_UndoLastGalvWeigh] 
    @UserName NVARCHAR(50)
    -- add more stored procedure parameters here
AS
BEGIN
    SET NOCOUNT ON;

    -- Non SP Declares
    DECLARE @JobNo INT;
    DECLARE @SeqNo INT;
    DECLARE @Mass DECIMAL(18, 2)

    SELECT TOP 1 @JobNo = JobNo
        , @SeqNo = SequenceNo
        , @Mass = [Weight] 
    FROM tblCompletedJobs 
    WHERE SequenceNo IS NOT NULL
    ORDER BY [DateTime] DESC

    -- STEP 1: UPDATE RECORD IN tblCompletedJobs
    UPDATE tblCompletedJobs
    SET Reference = @SeqNo
        , SequenceNo = NULL
        , Customer = NULL
        , Department = NULL
        , Machine = NULL
        , WireSize = NULL
        , ActualWireSize = NULL
        , WireTol = NULL
        , [Type] = NULL
        , DV = NULL
        , MPASpec = NULL
        , TreatedMPA = NULL
        , ZincSpec = NULL
        , TestedZinc = NULL
        , RodSize = NULL
        , RodSpec = NULL
        , CastNo = NULL
        , TensileTicket = NULL
        , [Weight] = NULL
        , ProductName = NULL
        , Gas = NULL
        , Regrade = NULL
        , OldTicketNo = NULL
        , RegradeRef = NULL
        , SECode = NULL
        , WDBlackTol = NULL
        , GalvRPM = NULL
        , Operator = @UserName
        , Hold = NULL
        , Stockchanged = NULL
        , ZincInitialMass = NULL
        , ZincStripMass = NULL
        , ZincStripSize = NULL
        , GrossMass = NULL
        , TareMass = NULL
        , Remarks = NULL
        , Remarks2 = NULL
        , Remarks3 = NULL
    FROM tblCompletedJobs
    WHERE JobNo = @JobNo
        AND SequenceNo = @SeqNo

    -- STEP 2: REVERT AND SET TO NOT WEIGHED IN tblPendingJobs
    UPDATE tblPendingJobs
    SET Weighed = 'N'
    WHERE JobNo = @JobNo
        AND SeqNo = @SeqNo

    -- STEP 3: UPDATE THE MassProduced IN tblNewJobs TO LESS WHAT WAS PREVIOUSLY WEIGHED
    UPDATE tblNewJobs
    SET MassProduced = ISNULL(MassProduced, 0) + - @Mass
    WHERE JobNo = @JobNo

    -- STEP 4: UPDATE THE MassProduced IN tblQCPhase1 TO LESS WHAT WAS PREVIOUSLY WEIGHED
    UPDATE tblQCPhase1
    SET MassProduced = ISNULL(MassProduced, 0) + - @Mass
    WHERE JobNo = @JobNo

    -- STEP 5: REVERT tblRegradeJobs INSERT FOR JOBS ON HOLD
    UPDATE tblRegradeJobs
    SET Reference = NULL
        , Customer = NULL
        , Department = NULL
        , Machine = NULL
        , WireSize = NULL
        , ActualWireSize = NULL
        , WireTol = NULL
        , [Type] = NULL
        , DV = NULL
        , MPASpec = NULL
        , TreatedMPA = NULL
        , ZincSpec = NULL
        , TestedZinc = NULL
        , RodSize = NULL
        , RodSpec = NULL
        , CastNo = NULL
        , TensileTicket = NULL
        , [Weight] = NULL
        , ProductName = NULL
        , Gas = NULL
        , SECode = NULL
        , WDBlackTol = NULL
        , GalvRPM = NULL
        , ZincInitialMass = NULL
        , ZincStripMass = NULL
        , ZincStripSize = NULL
        , GrossMass = NULL
        , TareMass = NULL
        , Operator = @UserName
        , Remarks = NULL
        , Remarks2 = NULL
        , Remarks3 = NULL
        , intStressTest = NULL
        , intElongationAtBreak = NULL
        , intTorsionTest = NULL
        , intOneDiameterWrapTest = NULL
        , strCoatingUniformity = NULL
    FROM tblRegradeJobs
    WHERE JobNo = @JobNo
        AND SequenceNo = @SeqNo

    SELECT 'Success' AS Result
END
GO
