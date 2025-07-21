USE [linxdbDIMSHendok]
GO

/****** Object:  Table [dbo].[tblStockChange_To]    Script Date: 2025/07/21 15:08:43 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

CREATE TABLE [dbo].[tblStockChange_To](
	[ToID] [int] IDENTITY(1,1) NOT NULL,
	[DCID] [int] NOT NULL,
	[WarehouseID] [int] NOT NULL,
	[ZoneID] [int] NOT NULL,
	[DepartmentID] [int] NOT NULL,
	[CategoryID] [varchar](400) NOT NULL,
	[Product] [nvarchar](100) NOT NULL,
	[TypeWeight] [nvarchar](50) NULL,
	[ChangedAt] [datetime] NOT NULL,
	[ChangedBy] [int] NOT NULL,
	[StockType] [nvarchar](500) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[ToID] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO



