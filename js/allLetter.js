function allLetter(texto)  
{   
    var letters = /^[A-Za-z]+$/;  
    if(!texto.value.match(letters))  
    {  
      alert('Inserte sólo caracteres alfanuméricos');
      return false;  
    }  
}