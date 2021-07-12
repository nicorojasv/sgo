window.onload = function (){
//Cajas de Texto Dotacion Equivalente
var d_equiv1 = document.getElementById("d_equiv1").value;
var d_equiv2 = document.getElementById("d_equiv2").value;
var d_equiv3 = document.getElementById("d_equiv3").value;
var d_equiv4 = document.getElementById("d_equiv4").value;
var d_equiv5 = document.getElementById("d_equiv5").value;
var d_equiv6 = document.getElementById("d_equiv6").value;
var d_equiv7 = document.getElementById("d_equiv7").value;
var d_equiv8 = document.getElementById("d_equiv8").value;
var d_equiv9 = document.getElementById("d_equiv9").value;
var d_equiv10 = document.getElementById("d_equiv10").value;
var d_equiv11 = document.getElementById("d_equiv11").value;
var d_equiv12 = document.getElementById("d_equiv12").value;
//Cajas de Texto Cantidad Contratos Vigentes al Mes
var c_contratos1 = document.getElementById("c_contratos1").value;
var c_contratos2 = document.getElementById("c_contratos2").value;
var c_contratos3 = document.getElementById("c_contratos3").value;
var c_contratos4 = document.getElementById("c_contratos4").value;
var c_contratos5 = document.getElementById("c_contratos5").value;
var c_contratos6 = document.getElementById("c_contratos6").value;
var c_contratos7 = document.getElementById("c_contratos7").value;
var c_contratos8 = document.getElementById("c_contratos8").value;
var c_contratos9 = document.getElementById("c_contratos9").value;
var c_contratos10 = document.getElementById("c_contratos10").value;
var c_contratos11 = document.getElementById("c_contratos11").value;
var c_contratos12 = document.getElementById("c_contratos12").value;
//Cajas de Texto por Trabajador o Rut
var por_trabajador1 = document.getElementById("por_trabajador1").value;
var por_trabajador2 = document.getElementById("por_trabajador2").value;
var por_trabajador3 = document.getElementById("por_trabajador3").value;
var por_trabajador4 = document.getElementById("por_trabajador4").value;
var por_trabajador5 = document.getElementById("por_trabajador5").value;
var por_trabajador6 = document.getElementById("por_trabajador6").value;
var por_trabajador7 = document.getElementById("por_trabajador7").value;
var por_trabajador8 = document.getElementById("por_trabajador8").value;
var por_trabajador9 = document.getElementById("por_trabajador9").value;
var por_trabajador10 = document.getElementById("por_trabajador10").value;
var por_trabajador11 = document.getElementById("por_trabajador11").value;
var por_trabajador12 = document.getElementById("por_trabajador12").value;

var chart = new CanvasJS.Chart("chartContainer1",
    {
      theme:"theme1",
      animationEnabled: true,
      axisY :{
        includeZero: false,
        // suffix: " k",
        valueFormatString: "#.",
        suffix: ""
        
      },
      toolTip: {
        shared: "true"
      },
      data: [
      {
        type: "spline",
        showInLegend: true,
        name: "Cantidad",
        dataPoints: [
        {label: "Enero", y: Number(d_equiv1)},
        {label: "Febrero", y: Number(d_equiv2)},
        {label: "Marzo", y: Number(d_equiv3)},
        {label: "Abril", y: Number(d_equiv4)},
        {label: "Mayo", y: Number(d_equiv5)},
        {label: "Junio", y: Number(d_equiv6)},
        {label: "Julio", y: Number(d_equiv7)},
        {label: "Agosto", y: Number(d_equiv8)},
        {label: "Septiembre", y: Number(d_equiv9)},
        {label: "Octubre", y: Number(d_equiv10)},
        {label: "Noviembre", y: Number(d_equiv11)},
        {label: "Diciembre", y: Number(d_equiv12)}
        ]
      },
      ],
      legend:{
        cursor:"pointer",
        itemclick : function(e) {
          if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible ){
            e.dataSeries.visible = false;
          }
          else {
            e.dataSeries.visible = true;
          }
          chart.render();
        }
        
      },
    });
chart.render();

var chart = new CanvasJS.Chart("chartContainer2",
    {
      theme:"theme2",
      animationEnabled: true,
      axisY :{
        includeZero: false,
        valueFormatString: "#.",
        suffix: ""
      },
      toolTip: {
        shared: "true"
      },
      data: [
      {
        type: "spline", 
        showInLegend: true,
        name: "Cantidad",
        dataPoints: [
        {label: "Enero", y: Number(c_contratos1)},
        {label: "Febrero", y: Number(c_contratos2)},
        {label: "Marzo", y: Number(c_contratos3)},
        {label: "Abril", y: Number(c_contratos4)},
        {label: "Mayo", y: Number(c_contratos5)},
        {label: "Junio", y: Number(c_contratos6)},
        {label: "Julio", y: Number(c_contratos7)},
        {label: "Agosto", y: Number(c_contratos8)},
        {label: "Septiembre", y: Number(c_contratos9)},
        {label: "Octubre", y: Number(c_contratos10)},
        {label: "Noviembre", y: Number(c_contratos11)},
        {label: "Diciembre", y: Number(c_contratos12)}
        ]
      },
      ],
      legend:{
        cursor:"pointer",
        itemclick : function(e) {
          if (typeof(e.dataSeries.visible) === "indefinido" || e.dataSeries.visible ){
            e.dataSeries.visible = false;
          }
          else {
            e.dataSeries.visible = true;
          }
          chart.render();
        }
        
      },
    });
chart.render();

var chart = new CanvasJS.Chart("chartContainer3",
    {
      theme:"theme3",
      animationEnabled: true,
      axisY :{
        includeZero: false,
        valueFormatString: "#.",
        suffix: ""
      },
      toolTip: {
        shared: "true"
      },
      data: [
      {
        type: "spline", 
        showInLegend: true,
        name: "Cantidad",
        dataPoints: [
        {label: "Enero", y: Number(por_trabajador1)},
        {label: "Febrero", y: Number(por_trabajador2)},
        {label: "Marzo", y: Number(por_trabajador3)},
        {label: "Abril", y: Number(por_trabajador4)},
        {label: "Mayo", y: Number(por_trabajador5)},
        {label: "Junio", y: Number(por_trabajador6)},
        {label: "Julio", y: Number(por_trabajador7)},
        {label: "Agosto", y: Number(por_trabajador8)},
        {label: "Septiembre", y: Number(por_trabajador9)},
        {label: "Octubre", y: Number(por_trabajador10)},
        {label: "Noviembre", y: Number(por_trabajador11)},
        {label: "Diciembre", y: Number(por_trabajador12)}
        ]
      },
      ],
      legend:{
        cursor:"pointer",
        itemclick : function(e) {
          if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible ){
            e.dataSeries.visible = false;
          }
          else {
            e.dataSeries.visible = true;
          }
          chart.render();
        }
        
      },
    });
chart.render();

}