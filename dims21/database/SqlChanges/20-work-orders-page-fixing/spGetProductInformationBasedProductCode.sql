SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		Kyle W
-- Create date: 2023-02-14
-- Description: Gets the product Information based on the Product Code
-- =============================================
ALTER PROCEDURE [dbo].[spGetProductInformationBasedProductCode]
	-- Add the parameters for the stored procedure here
	@code NVARCHAR(50)
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;

    SELECT * FROM (
        SELECT
            ISNULL(fu.Barcode,'0000000000000') AS Barcode,
            fu.Description_1 AS ProductDescription,
            fu.Code AS ItemCode,
            fu.ucIILabelHeader AS strItemGroup,
            fu.weight,
            fu.uiIIPackSize AS strPackSize,
            fu.uiIIBundleSize AS strBundleSize,
            CASE WHEN NULLIF(fu.ulIISingleLabel, '') IS NULL THEN 0 ELSE 1 END AS intHasSingleLable,
            CASE WHEN NULLIF(fu.ulIIBundleLabel, '') IS NULL THEN 0 ELSE 1 END AS intHasBundleLable,
            CASE WHEN NULLIF(fu.ulIIPalletLabel, '') IS NULL THEN 0 ELSE 1 END AS intHasPalletLable
        FROM [tblSageFullStock] fu

        UNION ALL

        SELECT 
            ISNULL(n.Barcode,'0000000000000') AS Barcode,
            n.Description_1 AS ProductDescription,
            n.Code AS ItemCode,
            N.ucIILabelHeader AS strItemGroup,
            NULL weight,
            N.ucIILabelDescription2 AS strPackSize,
            NULL AS strBundleSize,
            1 intHasSingleLable, 
            0 intHasBundleLable,
            0 intHasPalletLable
        FROM tblNailsInner n
    ) AS products
    WHERE products.ItemCode = @code 

END
GO
