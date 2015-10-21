var DSGSTF;
(function (DSGSTF) {
    var petitions;
    (function (petitions) {


        try {
            var voteTemplate = Handlebars.compile(document.getElementById("vote-template").innerHTML);
            var littlePetitionTemplate = Handlebars.compile(document.getElementById("little-petition-template").innerHTML);
            var bigPetitionTemplate = Handlebars.compile(document.getElementById("big-petition-template").innerHTML);
            var userInfoEl = document.getElementById('userInfo');
            
            getUser().then(function(user) {
                petitions.user = user;
                //print user info
                userInfoEl.innerHTML = user.netid + " (" + user.votes + " votes remaining) " + (user.admin ? "[admin]" : "");
            });
           
        } catch (err) {
            console.log(err);  
        }
        var petitionListEl = document.getElementById("petition-list");
        // var votesLeftTemplate = Handlebars.compile(document.getElementById("votesLeft-template").innerHTML);
        var categories = [];
        var petitionList = [];
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

        // TODO: figure out if working
        function postReq(url, params) {
            return new Promise(function (resolve, reject) {
                //TODO run ajax request
                var req = new XMLHttpRequest();
                req.open("POST", url, true);
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

        petitions.getPetitionsData = function() {
            var location = "petition-list";
            var url = "/backend/petitions.php";
            getJSON(url).then(function (pets) {
                for (var i = 0; i < pets.length; i++) {
                    if (!(pets[i] in petitionList)) {
                        petitionListEl.push(pets[i]);
                    }
                    petitionList.innerHTML += littlePetitionTemplate(pets[i]);
                }
            });
        };


        //in HTML, use <button onclick = ""></button>
        //-- hopefully this will increase the vote by one
        petitions.voteOnce = function(petitionId){
            var url = "/backend/petitions.php";
            //-- vote once, and then update all the HTML
            postJSON(url, "petitionid="+petitionId).then(function(){
                getJSON(url).then(function(pets){
                    petitionListEl = [];
                    petitionList.innerHTML = null;
                    for (var i = 0; i < pets.length; i++) {
                        petitionListEl.push(pets[i]);
                        petitionList.innerHTML += littlePetitionTemplate(pets[i]);
                    }
                });
            });
        }

        //-- create new petition, then update petitionListEl and HTML
        petitions.postPetitionsData = function (JSONdata) {
            var url = "/backend/petitions.php";
            postReq(url, JSONdata).then(function(){
                getJSON(url).then(function (pets) {
                    for (var i = 0; i < pets.length; i++) {
                        if (!(pets[i] in petitionList)) {
                            petitionListEl.push(pets[i]);
                        }
                        petitionList.innerHTML += littlePetitionTemplate(pets[i]);
                    }
                });
            });
        };

        petitions.getCategoriesData = function () {
            var location = "row";
            var url = "/backend/categories.php";
            getJSON(url).then(function (cats) {
                for (var i=0; i<cats.length; i++) {
                    if (!(cats[i] in categories)) {
                        categories.push(cats[i]);
                    }
                }
            });
        };

        // get netid from $_ENV shibboleth
        petitions.getVotesLeft = function () {
            var location = "votesLeft";
            var url = "/backend/votesLeft";
            getJSON(url).then(function (votes) {

            });
        };

        petitions.getAdminData = function () {
            var location = "admins";
            var url = "/backend/admins";
            getJSON(url).then(function (admins) {
                for (var i = 0; i < adminList.length; i++) {
                    if (!(adminList[i] in admins)) {
                        admins.push(adminList[i]);
                    }
                }
            });
        };
        
        petitions.getUser = function() {
            getJSON("/votesLeft");
        }


    })(petitions = DSGSTF.petitions || (DSGSTF.petitions = {}));
})(DSGSTF || (DSGSTF = {}));
