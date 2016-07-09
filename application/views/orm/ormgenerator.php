<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-15">
        <title></title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?=base_url('css/jquery-ui.css')?>"/>
        <style>
            body{font-size:12px;}
        </style>
        <script>
            $(document).ready(function() {                
                $( "#dialog" ).dialog({
                    title: 'Foreign keys',
                    resizable: false,
                    height:140,
                    modal: true,
                    buttons: {
                        "Yes": function() {
                            window.location = "<?=base_url('ormgenerator/withforeing')?>";
                        },
                        "No": function() {
                            window.location = "<?=base_url('ormgenerator/withoutforeing')?>";
                        }
                    }
                });
            });
        </script>
        
    </head>    
    <body>
        <div id="dialog">
            Do you want generate Foreign Keys for your model?
        </div>
    </body>
</html>
