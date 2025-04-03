USE [linxdbDIMSHendok]
GO

/****** Object:  Table [dbo].[tblApproveUpliftment]    Script Date: 2025/04/03 09:25:30 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[tblApproveUpliftment](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[userid] [int] NULL,
	[intupliftmentnumber] [varchar](100) NULL,
	[bitApproved] [bit] NULL,
	[strComment] [varchar](max) NULL,
	[dtmApproved] [datetime] NULL,
 CONSTRAINT [PK_tblApproveUpliftment] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
