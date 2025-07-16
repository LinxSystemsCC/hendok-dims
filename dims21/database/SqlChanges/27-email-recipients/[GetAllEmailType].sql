USE [linxdbDIMSHendok]
GO

/****** Object:  StoredProcedure [dbo].[GetAllEmailType]    Script Date: 2025/07/10 10:27:21 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

  create procedure [dbo].[GetAllEmailType]

  as
  begin
  

   select * from [dbo].[tblEmailTypes]

   end
GO


