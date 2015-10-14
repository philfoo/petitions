var DSGSTF;
(function (DSGSTF) {
    var petitions;
    (function (petitions) {
        
        
        
        var voteTemplate = Handlebars.compile(document.getElementById("vote-template").innerHTML);
        var littlePetitionTemplate = Handlebars.compile(document.getElementById("little-petition-template").innerHTML);
        var bigPetitionTemplate = Handlebars.compile(document.getElementById("big-petition-template").innerHTML);
        var petitionList = document.getElementById("petition-list");
        // var votesLeftTemplate = Handlebars.compile(document.getElementById("votesLeft-template").innerHTML);
        var categories = [];
        var petitions = [];
        var admins = [];
        function getJSON(url) {
            return new Promise(function (resolve, reject) {
                //TODO run ajax request
                var req = new XMLHttpRequest();
                req.open("GET", url);
                req.onload = function () {
                    if (req.status === 200) {
                        resolve(JSON.parse(req.response));
                    }
                    else {
                        reject(Error(req.statusText));
                    }
                };
                req.onerror = function () { reject(Error("Could not get JSON. Network Error.")); };
                req.send();
            });
        }


        function postReq(url, params) {
            return new Promise(function (resolve, reject) {
                //TODO run ajax request
                var req = new XMLHttpRequest();
                req.open("POST", url);
                req.onload = function () {
                    if (req.status === 200) {
                        resolve(req.response);
                    }
                    else {
                        reject(Error(req.statusText));
                    }
                };
                req.onerror = function () { reject(Error("Could not process POST request. Network Error.")); };
                req.send(params);
            });
        }
        
        var getPetitionsData = function () {
            var location = "petition-list";
            var url = "/backend/petitions";
            getJSON(url).then(function (pets) {
                for (var i=0; i<pets.length; i++) {
                    if (!(pets[i] in petitions)) {
                        petitions.push(pets[i]);
                    }
                    petitionList.innerHTML += littlePetitionTemplate(pets[i]);
                }
            });
        };

        //in HTML, use <button onclick = ""></button>
        //-- hopefully this will increase the vote by one
        postPetitionsData = function(petitionId){
            var url = "/backend/petitions" + "/" + petitionId;
            postReq(url);
        };
        
        
        
        var getCategoriesData = function () {
            var location = "row";
            var url = "/backend/categories";
            getJSON(url).then(function (cats) {
                for (var i=0; i<cats.length; i++) {
                    if (!(cats[i] in categories)) {
                        categories.push(cats[i]);
                    }
                }
            });
        };


        // get netid from $_ENV shibboleth
        var getVotesLeft = function () {
            var location = "votesLeft";
            var url = "/backend/votesLeft";
            getJSON(url).then(function (votes) {
                
            });
        };


        var getAdminData = function(){
            var location = "admins";
            var url = "/backend/admins";
            getJSON(url).then(function (admins) {
                for (var i=0; i<adminList.length; i++) {
                    if (!(adminList[i] in admins)) {
                        admins.push(adminList[i]);
                    }
                }
            });
        }
        
        
        
    })(petitions = DSGSTF.petitions || (DSGSTF.petitions = {}));
})(DSGSTF || (DSGSTF = {}));
