USE [linxdbDIMSHendok]
GO

/****** Object:  Table [dbo].[tblEmailReportRecipients]    Script Date: 2025/07/10 10:23:26 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[tblEmailReportRecipients](
	[intAutoId] [bigint] IDENTITY(1,1) NOT NULL,
	[strType] [nvarchar](50) NULL,
	[strEmail] [nvarchar](100) NULL,
	[intUserId] [int] NULL,
	[dtmCreated] [datetime] NULL,
 CONSTRAINT [PK_tblEmailReportRecipients] PRIMARY KEY CLUSTERED 
(
	[intAutoId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO

ALTER TABLE [dbo].[tblEmailReportRecipients] ADD  CONSTRAINT [DEFAULT_tblEmailReportRecipients_dtmCreated]  DEFAULT (getdate()) FOR [dtmCreated]
GO


