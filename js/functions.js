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

function numeroCarta()
{
  var codice = document.getElementById(id);
  switch(codice.lenght)
  {
    case 4:
    case 9:
    case 14:
    codice.value += "-";
  }
}

function tornaIndietro()
{
    window.history.back();
}
