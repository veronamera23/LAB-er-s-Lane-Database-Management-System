const LabDirectory = new Array();

function genLabID(){
    return Math.floor(100000 + Math.random()*(900000))
}

function getLabInfo(){
    var LabID = genLabID();
    var LabName = document.getElementById("LabName").value;
    var LabCon = document.getElementById("LabCon").value;
    var LabLoc = document.getElementById("LabLoc").value;
    var SelDept = document.getElementById("SelDept").value;

    const Lab = {
        LabID: null,
        LabName: null,
        LabCon: null,
        LabLoc: null,
        SelDept: null
    }

    Lab.LabID = "1000 - " + LabID;
    Lab.LabName = LabName;
    Lab.LabCon = LabCon;
    Lab.LabLoc = LabLoc;
    Lab.SelDept = SelDept;

    console.log(Lab)
    LabDirectory.push(Lab);
    console.log(LabDirectory);
}


