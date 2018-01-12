function checkPassword(input)
{
   if (input.value != document.getElementById('password').value)
      input.setCustomValidity("La password non corrisponde.");
  else
      input.setCustomValidity('');
}

function asyncRequest(page,method)
{
  xhttp.open(method, page, true);
  return xhttp.send();
}

function disable(id)
{
  document.getElementById(id).style = "display:none;";
}

function enable(id)
{
  document.getElementById(id).style = "";
  document.getElementById(id).class = "row";
}

function disableEnable(id)
{
  if(document.getElementById('checkbox').checked == true)
  {
    disable(id);
  }
  else
  {
    enable(id);
  }
}


function numeroCarta(id)
{
  var codice = id.value.toString();
  //console.log(codice.length);
  switch(codice.length)
  {
    case 4:
    case 9:
    case 14:
      id.value += "-";
  }
}

function tornaIndietro()
{
    window.history.back();
}
