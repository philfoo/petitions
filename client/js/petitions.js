var DSGSTF;
(function (DSGSTF) {
    var petitions;
    (function (petitions) {
        
        
        
        var voteTemplate = Handlebars.compile(document.getElementById("vote-template").innerHTML);
        var littlePetitionTemplate = Handlebars.compile(document.getElementById("little-petition-template").innerHTML);
        var bigPetitionTemplate = Handlebars.compile(document.getElementById("big-petition-template").innerHTML);
        var petitionList = document.getElementById("petition-list");
        var categories = [];
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
                req.onerror = function () { reject(Error("Could not getJSON. Network Error.")); };
                req.send();
            });
        }
        
        
        
        var getPetitionsData = function () {
            // var url = '';
            var location = "petition-list";
            var url = "/backend/petitions";
            getJSON(url).then(function (pets) {
                for (var i in pets) {
                    petitionList.innerHTML += littlePetitionTemplate(pets);
                }
            });
        };
        
        
        
        var getCategoriesData = function () {
            var location = "row";
            var url = "/backend/categories";
            getJSON(url).then(function (cats) {
                for (var i in cats) {
                    if (!(cats[i] in categories)) {
                        categories.push(cats[i]);
                    }
                }
            });
        };
        
        
        
        getPetitionsData();
        
        
        
    })(petitions = DSGSTF.petitions || (DSGSTF.petitions = {}));
})(DSGSTF || (DSGSTF = {}));
