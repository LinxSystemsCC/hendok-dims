SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tblWorkOrders](
	[intAutoId] [int] IDENTITY(1,1) NOT NULL,
	[intDepartmentId] [int] NULL,
	[intMachineId] [int] NULL,
	[strProductCode] [nvarchar](50) NULL,
	[intSequence] [int] NULL,
	[decQtyRequired] [decimal](18, 2) NULL,
	[decQtyProduced] [decimal](18, 2) NULL,
	[decQtyConfiguration] [decimal](18, 2) NULL,
	[strConfigurationType] [nvarchar](10) NULL,
	[intStatusId] [int] NULL,
	[intCreatedBy] [int] NULL,
	[dtmCreated] [datetime] NULL,
	[dtePropStart] [date] NULL,
	[intStartedBy] [int] NULL,
	[dtmStarted] [datetime] NULL,
	[intEndedBy] [int] NULL,
	[dtmEnded] [datetime] NULL
) ON [PRIMARY]
GO
ALTER TABLE [dbo].[tblWorkOrders] ADD  CONSTRAINT [PK_tblWorkOrders] PRIMARY KEY CLUSTERED 
(
	[intAutoId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
