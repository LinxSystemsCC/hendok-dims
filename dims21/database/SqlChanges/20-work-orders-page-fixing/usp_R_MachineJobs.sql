SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		Kyle Westran
-- Create date: 2025-06-23
-- Description:	Get active jobs on a specific machine
-- =============================================
ALTER PROCEDURE [dbo].[usp_R_MachineJobs]
	-- Add the parameters for the stored procedure here
	@intMachineId AS INT
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;

	SELECT
		jobs.intAutoId
		, stk.Code AS strProductCode
		, stk.Description_1 AS strProductDescription
		, jobs.intSequence
		, jobs.intDepartmentId
		, dp.strDeptName AS strDepartmentName
		, jobs.intMachineId
		, m.strMachineName
		, jobs.decQtyRequired
		, jobs.decQtyProduced
		, jobs.decQtyConfiguration
		, jobs.strConfigurationType
		, jobs.intStatusId
		, jobs.intCreatedBy
		, cusr.UserName AS strCreatedBy
		, jobs.dtmCreated
		, jobs.dtePropStart
		, jobs.intStartedBy
		, susr.UserName AS strStartedBy
		, jobs.dtmStarted
		, jobs.intEndedBy
		, eusr.UserName AS strEndedBy
		, jobs.dtmEnded
	FROM tblWorkOrders jobs
	LEFT OUTER JOIN tblDIMSUSERS cusr ON cusr.UserId = jobs.intCreatedBy
	LEFT OUTER JOIN tblDIMSUSERS susr ON susr.UserId = jobs.intStartedBy
	LEFT OUTER JOIN tblDIMSUSERS eusr ON eusr.UserId = jobs.intEndedBy
	INNER JOIN tblMachines m ON m.intAutoMachineID = jobs.intMachineId
	INNER JOIN tblDepartments dp ON dp.intAutoID = jobs.intDepartmentId
	INNER JOIN tblSageFullStock stk ON stk.Code = jobs.strProductCode
	WHERE jobs.intMachineId = @intMachineId
	ORDER BY jobs.intSequence, jobs.intAutoId DESC
END
GO