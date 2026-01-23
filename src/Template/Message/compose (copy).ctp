  
  <script src="<?php echo SITE_URL; ?>/js/bootstrap-typeahead.js"></script>
   
   
  <section id="page_Messaging">
    <div class="container">
      <h2><span>Messaging</span></h2>
    </div>
<div class="mess-box-container">
      <div class="container">
        <div class="row profile-bg m-top-20">
        <h4 class="text-center">New Mail</h4>
           <?php echo  $this->element('messaginmenuleft') ?>
          <div class="col-sm-9">
            <div class="messaging-cntnt-box">
              
             <div class="msz-frm">
             <form class="form-horizontal">
             <input type="text" placeholder="Search.." name="search" class="form-control srch">
    
             <input type="text" name="to" id="to" class="form-control typeahead" placeholder="To"/>
             <input type="text" name="to_id" id="to_id "/>
             <input type="text" class="form-control" placeholder="Subject">
             <div class="msz-bx">
             <textarea class="form-control" placeholder="Description"> </textarea>
           
             </div>
             <button type="submit" class="btn btn-default">Send</button>
             </form>
             </div> 
            </div>
          </div>
        </div>
      </div>
</div>
  </section>
  

  
  
  
  
  
  
  
  <form id="form-hockey_v2" name="form-hockey_v2">
    <div class="typeahead__container">
        <div class="typeahead__field">
 
            <span class="typeahead__query">
                <input class="js-typeahead-hockey_v2" name="hockey_v2[query]" type="search" placeholder="Search" autocomplete="off">
            </span>
            <span class="typeahead__button">
                <button type="submit">
                    <i class="typeahead__search-icon"></i>
                </button>
            </span>
 
        </div>
    </div>
</form>
  
  
  
  
  
  
  <div class="ui-widget">
  <label for="city">Your city: </label>
  <input id="city">
  Powered by <a href="http://geonames.org">geonames.org</a>
</div>

<div class="ui-widget" style="margin-top:2em; font-family:Arial">
  Result:
  <div id="log" style="height: 200px; width: 300px; overflow: auto;" class="ui-widget-content"></div>
</div>
  
  <script>
  $(function() {
    function log( message ) {
      $( "<div>" ).text( message ).prependTo( "#log" );
      $( "#log" ).scrollTop( 0 );
    }

    $( "#city" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
          url: "http://gd.geobytes.com/AutoCompleteCity",
          dataType: "jsonp",
          data: {
            q: request.term
          },
          success: function( data ) {
            response( data );
          }
        });
      },
      minLength: 3,
      select: function( event, ui ) {
        log( ui.item ?
          "Selected: " + ui.item.label :
          "Nothing selected, input was " + this.value);
      },
      open: function() {
        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
    });
  });
</script>
  
  
  
  
  
  
  
<script>




typeof $.typeahead === 'function' && $.typeahead({
    input: '.js-typeahead-hockey_v2',
    minLength: 1,
    maxItem: 8,
    maxItemPerGroup: 6,
    order: "asc",
    hint: true,
    searchOnFocus: true,
    blurOnTab: false,
    matcher: function (item, displayKey) {
        if (item.id === "BOS") {
            // Disable Boston for X reason
            item.disabled = true;
        }
        // Add all items matched items
        return true;
    },
    multiselect: {
        limit: 10,
        limitTemplate: 'You can\'t select more than 10 teams',
        matchOn: ["id"],
        cancelOnBackspace: true,
        data: function () {
 
            var deferred = $.Deferred();
 
            setTimeout(function () {
                deferred.resolve([{
                    "matchedKey": "name",
                    "name": "Canadiens",
                    "img": "canadiens",
                    "city": "Montreal",
                    "id": "MTL",
                    "conference": "Eastern",
                    "division": "Northeast",
                    "group": "teams"
                }]);
            }, 2000);
 
            deferred.always(function () {
                console.log('data loaded from promise');
            });
 
            return deferred;
 
        },
        callback: {
            onClick: function (node, item, event) {
                console.log(item);
                alert(item.name + ' Clicked!');
            },
            onCancel: function (node, item, event) {
                console.log(item);
                alert(item.name + ' Removed!');
            }
        }
    },
    templateValue: "{{name}}",
    display: ["name", "city"],
    emptyTemplate: 'no result for {{query}}',
    source: {
        teams: {
            url: "/jquerytypeahead/hockey_v2.json"
        }
    },
    callback: {
        onClick: function (node, a, item, event) {
            console.log(item.name + ' Added!')
        },
        onSubmit: function (node, form, items, event) {
            event.preventDefault();
 
            alert(JSON.stringify(items))
        }
    },
    debug: true
});








</script>




