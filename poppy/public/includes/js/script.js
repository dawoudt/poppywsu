
$(document).ready(function(){


// All functions are called when documet is ready


// hide the questions heading until the parent is selected
  var initializeDropDownQuestions = function (){

    var questionHeading = $(".questionHeading");
    var selectDisabled = $("select:disabled");
    var questionHeading = selectDisabled.parent().find(".questionHeading").hide();

    $("select").on('change',function(){
      $("select:disabled").parent().find(".questionHeading").hide();
      $("select").not(":disabled").parent().find(".questionHeading").show();
    });



  }    

  // Initialise slider values.  
    
    var initializeSliderValues = function(){

        var slidersJQ = $(".slider");
        //Traversing all individual elements
        for(var i=0;i<slidersJQ.length;i++)
        {
          slidersJQ[i] = $(slidersJQ[i]);
          var sliderInputJQ = slidersJQ[i].parent().find("input");
          var sliderValue = slidersJQ[i].slider("option", "value");

          var sliderOptions = slidersJQ[i].slider("option");

          if( sliderOptions.hasOwnProperty("stepsString") )
            sliderValue = sliderOptions.stepsString[parseInt(sliderValue)];
          sliderInputJQ.val(sliderValue);
        }
        
    }

    var initializeForm = function(){
      initializeDropDownQuestions();
      initializeSliderValues();
    }
    $(window).load(initializeForm);


//  initilise sliders

/*
function submissionAlert(form, container){

  var form = $(form);
  var container = $(container);

  form.submit(function( event ) {
    container.show();
  //event.preventDefault();
  });


}
submissionAlert(".alertSubmit", ".modal-alert");

*/




    function initSlider(container, slider, childOutputSelector, childInputSelector)
    {

      if(childOutputSelector == null || childInputSelector == null)
      {
      //Debugging console message with Chrome/Firefox. Message will appear on F12 > Developer Console tab
          console.debug("Error with InitializeDropdowns: Passed mandatory parameters are null.");
          return;
      }
    
    //Converts parameters to JQuery element, if not a JQuery element already
      if(container instanceof jQuery == false)
        container = $(container);

      for(var i = 0; i < container.length; i++)
      {
        container[i] = $(container[i]); //Convert DOM element to JQ
        var sliderJQ = container[i].find(slider);
        var outputJQ = container[i].find(childOutputSelector);
        var inputJQ = container[i].find(childInputSelector);


      // this is hard coded due to the nature of sliders and labels
      // if new sliders are added with different values, it will need to be appended here.

        if (container[i].find("h4").text().search("feeling") > 1 )
        {
          container[i].find(".sliderLabel").text("I Am Feeling :");
          outputJQ.val("OK");
          //alert(container[i].find("p").text().search("feeling"));
          AssignSliderFeelingsChangeEvent(sliderJQ,  outputJQ, inputJQ);
        }
        else if (container[i].find("h4").text().search("long did you stay in hospital") > 1 )
        {
          container[i].find(".sliderLabel").text("Days :");
          outputJQ.val("0");
          //alert(container[i].find("p").text().search("feeling"));
           AssignSliderDayChangeEvent(sliderJQ,  outputJQ, inputJQ);//Made changes here Moslem before was different
        }
        else if (container[i].find("h4").text().search("long did the ") > 1 )
        {
          container[i].find(".sliderLabel").text("Minutes :");//Made changes here Moslem
          outputJQ.val("0");
          //alert(container[i].find("p").text().search("feeling"));
          AssignSliderChangeEvent(sliderJQ,  outputJQ, inputJQ);
        }
         else if (container[i].find("h4").text().search("helpful") > 1 )
        {
          container[i].find(".sliderLabel").text("The professional was :");
          outputJQ.val("Somewhat Helpful");
          //alert(container[i].find("p").text().search("feeling"));
          AssignSliderHelpfulChangeEvent(sliderJQ,  outputJQ, inputJQ);
        }
        else if (container[i].find("h4").text().search("old is your baby today") > 1 )
        {
          container[i].find(".sliderLabel").text("Weeks :");
          outputJQ.val("0");
          //alert(container[i].find("p").text().search("feeling"));
          AssignSliderAgeChangeEvent(sliderJQ,  outputJQ, inputJQ);
        }
        else if (container[i].find("h4").text().search("old is your baby now") > 1 )
        {
          container[i].find(".sliderLabel").text("Hours :");
          outputJQ.val("0");
          //alert(container[i].find("p").text().search("feeling"));
          AssignSliderAgeChangeEvent(sliderJQ,  outputJQ, inputJQ);
        }
      }

    }

    initSlider(".form-group", ".slider", ".sliderOutput", ".sliderInput");
    

    // Initlising slider label values

    function AssignSliderChangeEvent(sliderJQ, output, input)
    {
    //Checks if you input the mandatory fields into the function
    if(input == null || output == null || sliderJQ == null)
      {
      //Debugging console message with Chrome/Firefox. Message will appear on F12 > Developer Console tab
        console.debug("Error with AssignTextChangeEvent: Passed mandatory parameters are null.");
        return;
      }
      input = input || "";
      //Converts triggerElementJQ and targetJQ to JQuery element, if not a JQuery element already
      if(output instanceof jQuery == false)
        output = $(output);
      if(input instanceof jQuery == false)
        input = $(input);
      if(sliderJQ instanceof jQuery == false)
        sliderJQ = $(sliderJQ);


		
        sliderJQ.slider({
        range: "max",
        min: 0,
        max: 120,
        value: 0,
        step: 5,
        slide: function( event, ui ) {
         $(this).parent().find(output).val( ui.value );
         $(this).parent().find(input).val(ui.value);
        }
      });
  }

// Initlising slider label values
   function AssignSliderFeelingsChangeEvent(sliderJQ, output, input)
    {
    //Checks if you input the mandatory fields into the function
    if(input == null || output == null || sliderJQ == null)
      {
      //Debugging console message with Chrome/Firefox. Message will appear on F12 > Developer Console tab
        console.debug("Error with AssignTextChangeEvent: Passed mandatory parameters are null.");
        return;
      }
      input = input || "";
      //Converts triggerElementJQ and targetJQ to JQuery element, if not a JQuery element already
      if(output instanceof jQuery == false)
        output = $(output);
      if(input instanceof jQuery == false)
        input = $(input);
      if(sliderJQ instanceof jQuery == false)
        sliderJQ = $(sliderJQ);



         var steps = [
            "Very sad",
            "Sad",
            "OK",
            "Happy",
            "Very happy"
            ];
    

          sliderJQ.slider({
            range: "max",
            value: 2,
            min: 0,
            max: 4,
            step: 1,
            stepsString: steps,
        slide: function( event, ui ) {
         $(this).parent().find(output).val(steps[ ui.value ]);
         $(this).parent().find(input).val(steps[ui.value]);
        }
      });
  }

// Initlising slider label values// Initlising slider label values
function AssignSliderHelpfulChangeEvent(sliderJQ, output, input)
    {
    //Checks if you input the mandatory fields into the function
    if(input == null || output == null || sliderJQ == null)
      {
      //Debugging console message with Chrome/Firefox. Message will appear on F12 > Developer Console tab
        console.debug("Error with AssignTextChangeEvent: Passed mandatory parameters are null.");
        return;
      }
      input = input || "";
      //Converts triggerElementJQ and targetJQ to JQuery element, if not a JQuery element already
      if(output instanceof jQuery == false)
        output = $(output);
      if(input instanceof jQuery == false)
        input = $(input);
      if(sliderJQ instanceof jQuery == false)
        sliderJQ = $(sliderJQ);



         var steps = [
            "Not Helpful at all",
            "Somewhat Helpful",
            "Very Helpful"
            ];
    

          sliderJQ.slider({
            range: "max",
            value: 1,
            min: 0,
            max: 2,
            step: 1,
            stepsString: steps,
        slide: function( event, ui ) {
         $(this).parent().find(output).val(steps[ ui.value ]);
         $(this).parent().find(input).val(steps[ui.value]);
        }
      });
  }


// Initlising slider label values
function AssignSliderAgeChangeEvent(sliderJQ, output, input)
    {
    //Checks if you input the mandatory fields into the function
    if(input == null || output == null || sliderJQ == null)
      {
      //Debugging console message with Chrome/Firefox. Message will appear on F12 > Developer Console tab
        console.debug("Error with AssignTextChangeEvent: Passed mandatory parameters are null.");
        return;
      }
      input = input || "";
      //Converts triggerElementJQ and targetJQ to JQuery element, if not a JQuery element already
      if(output instanceof jQuery == false)
        output = $(output);
      if(input instanceof jQuery == false)
        input = $(input);
      if(sliderJQ instanceof jQuery == false)
        sliderJQ = $(sliderJQ);
   

          sliderJQ.slider({
            range: "max",
            value: 0,
            min: 0,
            max: 73,
            step: 1,
        slide: function( event, ui ) {
         $(this).parent().find(output).val(ui.value );
         $(this).parent().find(input).val(ui.value);
        }
      });
  }


function AssignSliderDayChangeEvent(sliderJQ, output, input)
    {
    //Checks if you input the mandatory fields into the function
    if(input == null || output == null || sliderJQ == null)
      {
      //Debugging console message with Chrome/Firefox. Message will appear on F12 > Developer Console tab
        console.debug("Error with AssignTextChangeEvent: Passed mandatory parameters are null.");
        return;
      }
      input = input || "";
      //Converts triggerElementJQ and targetJQ to JQuery element, if not a JQuery element already
      if(output instanceof jQuery == false)
        output = $(output);
      if(input instanceof jQuery == false)
        input = $(input);
      if(sliderJQ instanceof jQuery == false)
        sliderJQ = $(sliderJQ);
   

          sliderJQ.slider({
            range: "max",
            value: 0,
            min: 0,
            max: 21,
            step: 1,
        slide: function( event, ui ) {
         $(this).parent().find(output).val(ui.value );
         $(this).parent().find(input).val(ui.value);
        }
      });
  }


  // Initlising text area
  function initTextarea(container, childTextareaSelector, childInputSelector)
    {

      if(childTextareaSelector == null || childInputSelector == null || container == null)
      {
      //Debugging console message with Chrome/Firefox. Message will appear on F12 > Developer Console tab
          console.debug("Error with InitializeDropdowns: Passed mandatory parameters are null.");
          return;
      }
    
    //Converts parameters to JQuery element, if not a JQuery element already
      if(container instanceof jQuery == false)
        container = $(container);

      for(var i = 0; i < container.length; i++)
      {
        container[i] = $(container[i]); //Convert DOM element to JQ
        var textAreaJQ = container[i].find(childTextareaSelector);
        var inputJQ = container[i].find(childInputSelector);
        AssignTextareaChangeEvent(textAreaJQ, inputJQ);
      }

    }

    initTextarea(".divText", ".textArea", ".textInput");

    // assigning text area value to input for submission

  function AssignTextareaChangeEvent(textArea, input)
  {
    //Checks if you input the mandatory fields into the function
    if(textArea == null || input == null)
    {
      //Debugging console message with Chrome/Firefox. Message will appear on F12 > Developer Console tab
      console.debug("Error with AssignTextChangeEvent: Passed mandatory parameters are null.");
      return;
    }
    input = input || "";
    //Converts triggerElementJQ and targetJQ to JQuery element, if not a JQuery element already
    if(textArea instanceof jQuery == false)
      textArea = $(triggerElementJQ);
    if(input instanceof jQuery == false)
      input = $(targetJQ);
      
      $(".submit").click(function(e) {
      input.val(textArea.val());
    })
  }
  
    // used in view-answers.php to export data to csb
    function exportToCSV($table, filename) {

        var $rows = $table.find('tr:has(td)'),

            tmpColDelim = String.fromCharCode(11), // vertical tab character
            tmpRowDelim = String.fromCharCode(0), // null character

            // actual delimiter characters for csv format
            colDelim = '","',
            rowDelim = '"\r\n"',

            // get text from table into csv formatted String
            csv = '"' + $rows.map(function (i, row) {
                var $row = $(row),
                    $cols = $row.find('td');

                return $cols.map(function (j, col) {
                    var $col = $(col),
                        text = $col.text();

                    return text.replace(/"/g, '""');

                }).get().join(tmpColDelim);

            }).get().join(tmpRowDelim)
                .split(tmpRowDelim).join(rowDelim)
                .split(tmpColDelim).join(colDelim) + '"',
           
            csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

        $(this)
            .attr({
            'download': filename,
                'href': csvData,
                'target': '_blank'
        });
    }
   
    $(".export").on('click', function (event) {
        // csv Format
        exportToCSV.apply(this, [$('#dvData>table'), 'export.csv']);
    });

});
