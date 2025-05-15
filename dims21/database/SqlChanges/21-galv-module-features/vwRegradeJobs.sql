CREATE VIEW vwRegradeJobs
AS
SELECT rj.[DateTime]
    , rj.JobNo
    , rj.SequenceNo
    , rj.Reference
    , rj.Customer
    , rj.Department
    , rj.Machine
    , rj.WireSize
    , rj.ActualWireSize
    , rj.WireTol
    , rj.[Type]
    , rj.DV
    , rj.MPASpec
    , rj.TreatedMPA
    , rj.ZincSpec
    , rj.TestedZinc
    , rj.RodSize
    , rj.RodSpec
    , rj.CastNo
    , rj.TensileTicket
    , rj.[Weight]
    , rj.ProductName
    , rj.Gas
    , rj.TicketNo
    , rj.SECode
    , rj.WDBlackTol
    , rj.GalvRPM
    , rj.ZincInitialMass
    , rj.ZincStripMass
    , rj.ZincStripSize
    , rj.GrossMass
    , rj.TareMass
    , rj.Operator
    , rj.Remarks
    , rj.Remarks2
    , rj.Remarks3
    , rj.intSeq
    , rj.intStressTest
    , rj.intElongationAtBreak
    , rj.intTorsionTest
    , rj.intOneDiameterWrapTest
    , rj.strCoatingUniformity
    , rj.dtePassTime
    , rj.intJobId
    , bins.intBinId
    , bins.strBin AS strBinName
FROM tblRegradeJobs rj
LEFT OUTER JOIN tblJobQrcodeAllocation jobs
    ON jobs.intJobId = rj.intJobId
LEFT OUTER JOIN viewBinNames bins
    ON bins.intBinId = jobs.intBinId
