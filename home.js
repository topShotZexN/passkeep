(function () {
  setInterval(time,1000);

})();

function seconds_with_leading_zeros(dt)
{
  return((dt.getSeconds() < 10 ? '0' : '') + dt.getSeconds());
}
function minutes_with_leading_zeros(dt)
{
  return((dt.getMinutes() < 10 ? '0' : '') + dt.getMinutes());
}
function hours_with_leading_zeros(dt)
{
  return((dt.getHours() < 10 ? '0' : '') + dt.getHours());
}
function time(){
  var a = new Date();
  var hr = hours_with_leading_zeros(a)
  var min = minutes_with_leading_zeros(a)
  var sec = seconds_with_leading_zeros(a);


  document.getElementById("time").innerHTML= hr+":"+min+":"+sec;
  //document.getElementById("time").innerHTML= a.getDate()+"/"+a.getMonth()+"/"+a.getFullYear();

}
