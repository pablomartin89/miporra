<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15">
        <title></title>
        <link rel="stylesheet" type="text/css" href="<?=base_url('css/orm.css')?>"/>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?=base_url('css/jquery-ui.css')?>"/>
        <script>
            var foreings = {};
            
            $(document).ready(function(){
                var dataTables = JSON.stringify(<?=$tables?>);
                var dataTables = JSON.parse(dataTables);
                var cont = 0;
                for(var tableName in dataTables){
                    $('#tables tbody').append('<tr><td>'+tableName+'</td</tr>');
                    $('#foreingSelect').append("<option value='"+tableName+"'>"+tableName+"</option>");
                    if(cont == 0){
                        for(var i in dataTables[tableName]){
                            if(dataTables[tableName][i]["primary_key"]){
                                $('#foreingTable').append('<tr><td>'+dataTables[tableName][i]['name']+'</td</tr>');
                            }
                        }
                        
                        $('#foreingTable td').click(function(){
                            $('#foreingTable td').removeClass('trselected');                        
                            $(this).addClass('trselected');
                        });
                    }
                    cont++;
                }
                
                $('#tables tbody td').click(function(){
                    $('#addForeing').show();
                    $('#addForeing').attr('table',$(this).html());
                    tableName = $(this).html();
                    $('#foreing thead th').html("Foreings for "+[$(this).html()]);
                    if(foreings[tableName]!=undefined){
                        $.each(foreings[tableName],function(e,v){
                             $.each(v,function(a,b){
                                 $('#foreing thead th').append("<br/>"+e+" || "+a+" -> "+b);
                             });
                        });
                    }
                });
                
                $('#addForeing').click(function(){
                    var tableName = $(this).attr('table');
                    $('#fieldsTable').html('');
                    for(var i in dataTables[$(this).attr('table')]){
                        
                        $('#fieldsTable').append("<tr><td>"+dataTables[$(this).attr('table')][i]["name"]+"</td></tr>");
                        
                    }
                    $('#foreingTable td').removeClass('trselected');
                    
                    $( "#dialogFields" ).dialog({
                        title: 'Select fields and foreing table',
                        resizable: false,
                        modal: true,
                        width: '500px',
                        buttons: {                            
                            "New Field": function() {
                                
                                if(foreings[tableName]==undefined) foreings[tableName] = {};
                                if(foreings[tableName][$('#foreingSelect').val()]==undefined) foreings[tableName][$('#foreingSelect').val()] = {};
                                
                                foreings[tableName][$('#foreingSelect').val()][$('#fieldsTable .trselected').html()] = [$('#foreingTable .trselected').html()];
 
                                $('#foreing thead th').html("Foreings for "+[tableName]);
                                if(foreings[tableName]!=undefined){
                                    $.each(foreings[tableName],function(e,v){
                                         $.each(v,function(a,b){
                                             $('#foreing thead th').append("<br/>"+e+" || "+a+" -> "+b);
                                         });
                                    });
                                }
                                
                            },
                            "Close": function() {
                                $( this ).dialog( "close" );
                                
                            }
                        }
                    });
                    
                    $('#fieldsTable td').click(function(){
                         $('#fieldsTable td').removeClass('trselected');
                        
                            $(this).addClass('trselected');
                        
                    });
                });
                
                $('#foreingSelect').change(function(){
                    $('#foreingTable').html('');
                    for(var i in dataTables[tableName]){                        
                        if(dataTables[$(this).val()][i]!=undefined){
                            if(dataTables[$(this).val()][i]["primary_key"]){
                                $('#foreingTable').append('<tr><td>'+dataTables[$(this).val()][i]['name']+'</td</tr>');
                            }
                        }
                    }
                    
                    $('#foreingTable td').click(function(){
                        $('#foreingTable td').removeClass('trselected');
                        
                            $(this).addClass('trselected');
                    });
                });
                
                $('#send').click(function(){
                    $.ajax({
                            url: '<?=base_url('ormgenerator/withoutForeing')?>',
                            type: "POST",
                            data: {data: JSON.stringify(foreings) },
                            beforeSend: function(x) {
                              
                            },
                            success: function(result) {
                               $('body').html(result);
                            }
                  });
                });
                
                
            });
            
            
        </script>
            
    </head>
    <body> 
        <div style="float:left">
            <table id="tables">
                <thead>
                <th>Tables</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <div style="float:left; margin-left: 15px; text-align: center;">
            <table id="foreing">
                    <thead>
                    <th></th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            <button id="addForeing" style="display:none">add</button>
         </div>
        
        <div id="dialogFields" style="display:none; width: 200px;">
            <div  style="float: left">
                <br/>
                <table id="fieldsTable">
                    
                </table>
                
            </div>
            <div style="float: right; text-align: center;">
                <select id="foreingSelect">
                    
                </select>
                 <table width="100%" id="foreingTable">
                     
                 </table>
            </div>
        </div>
        <div style="clear:both"></div>
        <button id="send">send</button>
    </body>
</html>
