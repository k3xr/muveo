function addTema(){
    var tag = document.getElementById("tema").value;
    tag = $.trim(tag);
    if(tag===""){
        return;
    }
    var arrayTemas = [];
    $( "td > input" ).each( function() {
        arrayTemas.push( $( this ).val() );
    });
    var added = $.inArray(tag.toLowerCase(),arrayTemas);
    if( added < 0 ){
        arrayTemas.push(tag);
        var input = document.createElement('tr');
        input.innerHTML = "<td id=tag"+arrayTemas.length+
        "><input type=\"hidden\" name=\"tag"+arrayTemas.length+"\" value=\""+tag.toLowerCase()+"\">"+tag+
        "<button type=\"button\" class=\"btn deleteTag label label-danger\">Eliminar</button></td>"
        $("#tags").append(input);
        $("button.deleteTag").bind("click",function(){
            $(this).closest("td").remove();
        });
    }
}