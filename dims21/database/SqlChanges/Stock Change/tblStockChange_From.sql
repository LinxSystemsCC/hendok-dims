USE [linxdbDIMSHendok]
GO

/****** Object:  Table [dbo].[tblStockChange_From]    Script Date: 2025/07/21 15:11:00 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[tblStockChange_From](
	[FromID] [int] IDENTITY(1,1) NOT NULL,
	[DCID] [int] NOT NULL,
	[WarehouseID] [int] NOT NULL,
	[ZoneID] [int] NOT NULL,
	[DepartmentID] [int] NOT NULL,
	[CategoryID] [varchar](500) NOT NULL,
	[Product] [nvarchar](100) NOT NULL,
	[LabelType] [nvarchar](50) NULL,
	[Quantity] [int] NOT NULL,
	[ChangedAt] [datetime] NOT NULL,
	[ChangedBy] [int] NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[FromID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO


