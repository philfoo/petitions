$(function () {
  // Grab the template script
  var theTemplateScript = $("#example-template").html();

  // Compile the template
  var theTemplate = Handlebars.compile(theTemplateScript);

  // Define our data object
  // var context=$.getJSON("name.php", function(data){ //read in data as a string?
  //   var temp = $.parseJSON(data);
  //   var outData = {
  //     "netid": temp.netid;
  //     "name": temp.name;
  //     "petitionid": temp.petitionid;
  //     "comment": temp.comment;
  //     "tempstamp": temp.timestamp;
  //   }
  //   $("#result").html(theTemplate(outData));
  // });

  function getData(urll, location){ //location = "#result"
    // var url = '';
    $.get(urll, function(data, status){
      var obj = $.parseJSON(data);
      var theCompiledHtml = theTemplate(obj);
      $(location).html(theTemplate(theCompiledHtml));
    });
  }

  function postData(urll, data, location){
    $.post(urll, data, function(data, status){
      var obj = $.parseJSON(data);
      var theCompiledHtml = theTemplate(obj);
      $(location).html(theTemplate(theCompiledHtml));
    });
  }

  var getPetitionsData = function(){ //location = "#result"
    // var url = '';
    var location = "row";
    var url = "/backend/petitions";
    getData(url, location);
  }

  var getCategoriesData = function(){
    var location = "row";
    var url = "/backend/categories";
    getData(url, location);
  }

  getPetitionsData();

  // Pass our data to the template
  // var theCompiledHtml = theTemplate(context);

  // Add the compiled html to the page
  // $('.content-placeholder').html(theCompiledHtml);
});