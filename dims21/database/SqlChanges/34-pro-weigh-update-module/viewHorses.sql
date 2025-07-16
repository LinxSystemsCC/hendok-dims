SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER VIEW [dbo].[viewHorses] AS
    SELECT DISTINCT
        t.VEHICLE_REGISTRATION TruckId, ISNULL(t.FLEET_NUMBER, t.VEHICLE_REGISTRATION) TruckName, t.HORSE_TYPE TruckType, t.CAPACITY intTonnage,
        CASE
            WHEN p.strTrailorNo IS NOT NULL THEN 1
            ELSE 0
        END AS intInUse
        , t.TARE_WEIGHT TareWeight
    FROM dims_trucks t
    LEFT JOIN tblPickingPlanHeader p ON t.VEHICLE_REGISTRATION COLLATE DATABASE_DEFAULT = p.strTrailorNo AND (p.intStatus = 0 OR p.intStatus IS NULL)
    WHERE T.VEHICLE_TYPE = 'horse'
GO

