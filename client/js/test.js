$(function () {
  // Grab the template script
  var theTemplateScript = $("#votes-template").html();

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

  function ajaxCall(destinationUrl, callback){
    $.ajax({
      url:destinationUrl,  
      success:function(data) {
        callback(data); 
      }
    });
  }

  function getData(urll, location){ //location = "#result"
    // var url = '';
    ajaxCall(urll, function(data){
      var obj = $.parseJSON(data)
      $(location).html(theTemplate(obj));
    });
  }

// Handlebars.getData = function(type, callback, parameters){
//   switch(type){
//     case 'petitions':
//       $.ajax({
//         url: '/petitions'+parameters['petitionid'];
//         success: function(data){
//           callback(data);
//         },
//         async:true
//       });
//       break;
//     case 'users':
//       $.ajax({
//         url: '/users',
//         success: function(data){
//           callback(data);
//         },
//         async:true
//       });
//       break;
//     case 'votes':
//       $.ajax({
//         url: '/votes',
//         success: function(data){
//           callback(data);
//         },
//         async:true
//       });
//       break;
//     case 'categories':
//       $.ajax({
//         url: '/categories',
//         success: function(data){
//           callback(data);
//         },
//         async:true
//       });
//       break;
//   }
// }

//   Handlebars.getTemplate = function(name) {
//     if (Handlebars.templates === undefined || Handlebars.templates[name] === undefined) {
//         $.ajax({
//             url : 'templatesfolder/' + name + '.handlebars',
//             success : function(data) {
//                 if (Handlebars.templates === undefined) {
//                     Handlebars.templates = {};
//                 }
//                 Handlebars.templates[name] = Handlebars.compile(data);
//             },
//             async : false
//         });
//     }
//     return Handlebars.templates[name];
// };

  // Pass our data to the template
  var theCompiledHtml = theTemplate(context);

  // Add the compiled html to the page
  // $('.content-placeholder').html(theCompiledHtml);
});