///<reference path="typings/es6-promise/es6-promise.d.ts" />
//Colab Javascript utils
var utils;
(function (utils) {
    //TODO
    //runs ajax request for url, parses json, and returns a promise for the result
    //much credit for a reference implementation goes to http://www.html5rocks.com/en/tutorials/es6/promises/#toc-promisifying-xmlhttprequest
    //their work is fantastic <3 and makes my life so much better
    //and seriously this is almost line for line lifted from that page so give them money or something
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
    utils.getJSON = getJSON;
})(utils || (utils = {}));
