<!DOCTYPE html>
<html>
<head>
<title>Balance cuentas 2020</title>
<meta name="description" content="chart created using amCharts live editor" />
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">
<!-- amCharts javascript sources -->
<script type="text/javascript" src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script type="text/javascript" src="https://www.amcharts.com/lib/3/pie.js"></script>
			<script type="text/javascript" src="https://www.amcharts.com/lib/3/serial.js"></script>
		<script type="text/javascript" src="https://www.amcharts.com/lib/3/themes/dark.js"></script>
		<script type="text/javascript" src="https://www.amcharts.com/lib/3/themes/light.js"></script>
	<style>html,body{font-family: 'Sarabun', sans-serif;} h1,h2,h3,h4{text-align: center}h4{font-size: 180%;}</style>
<!-- amCharts javascript code -->
<script type="text/javascript">
AmCharts.makeChart("chartdiv",
{
"type": "pie",
"balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
"innerRadius": "40%",
"titleField": "category",
"valueField": "column-1",
"allLabels": [],
"balloon": {},
"legend": {
"enabled": true,
"align": "center",
"markerType": "circle",	"valueText": "[[value]]€"
},
"titles": [],
"dataProvider": [
{
"category": "Gastos Federación",
"column-1": "3201"
},
{
"category": "Gastos varios",
"column-1": "370"
},
{
"category": "Gastos campeonatos",
"column-1": "405"
},
{
"category": "Gastos administrativos",
"column-1": "235.74"
}
]
}
);
	
		AmCharts.makeChart("chartdiv2",
				{
					"type": "pie",
					"balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
					"innerRadius": "40%",
					"titleField": "category",
					"valueField": "column-1",
					"theme": "light",
					"allLabels": [],
					"balloon": {},
					"legend": {
						"enabled": true,
						"align": "center",
						"markerType": "circle",	"valueText": "[[value]]€"
					},
					"titles": [],
					"dataProvider": [
						{
							"category": "Ingresos cuotas",
							"column-1": "5253"
						},
						{
							"category": "Ingresos campeonatos",
							"column-1": "320"
						}
					]
				}
			);
	
			AmCharts.makeChart("chartdiv3",
				{
					"type": "serial",
					"categoryField": "category",
					"startDuration": 1,
					"theme": "dark",
					"categoryAxis": {
						"gridPosition": "start"
					},
					"trendLines": [],
					"graphs": [
						{
							"balloonText": "[[title]] of [[category]]:[[value]]",
							"bullet": "round",
							"id": "AmGraph-1",
							"title": "Cuenta Club ",
							"valueField": "Cuenta CPBass"
						},
					
					],
					"guides": [],
					"valueAxes": [
						{
							"id": "ValueAxis-1",
							"title": "Axis title"
						}
					],
					"allLabels": [],
					"balloon": {},
					"legend": {
						"enabled": true,
						"useGraphSettings": true,	"valueText": "[[value]]€"
					},
					"titles": [
						{
							"id": "Title-1",
							"size": 15,
							"text": ""
						}
					],
					"dataProvider": [
						{
							"category": "2017",
							"Cuenta CPBass": "4222.56"
						},
						{
							"category": "2018",
							"Cuenta CPBass": "7023.68"
						},
						{
							"category": "2019",
							"Cuenta CPBass": "9379.01"
						},
						{
							"category": "2020",
							"Cuenta CPBass": "10740.27"
						}
					]
				}
			);
</script>
</head>
<body><h1>Balance cuentas 2020 Catalunya Pro Bass</h1><div>
	<strong>Total en cuenta Catalunya Pro Bass: </strong>10.740,27€<br>
  <strong>Total en cuenta coto Fayon: </strong>2.445,85 € <br>
  <strong><br>
  Gastos 2020:</strong>
<!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->
  <span data-sheets-value="{'1':3,'3':-4211.74}" data-sheets-userformat="{'2':2050,'4':{'1':2,'2':10027008},'14':{'1':2,'2':16777215}}" data-sheets-formula="=SUMA(R[-8]C[0]:R[-8]C[4])">-4211,74</span>€ <br>
  <strong>Ingresos 2020: </strong>
  <!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->
  <span data-sheets-value="{'1':3,'3':5573}" data-sheets-userformat="{'2':2050,'4':{'1':2,'2':10027008},'14':{'1':2,'2':16777215}}" data-sheets-formula="=SUMA(R[-8]C[0]:R[-8]C[4])">5573€</span> </div>
  <h4>Gastos 2020</h4>
<div id="chartdiv" style="width: 100%; height: 400px; background-color: #FFFFFF;" ></div>
<div><center>
<h5>Gastos varios</h5><table width="400" border="0">
  <tbody>
    <tr>
      <td bgcolor="#D8D8D8">Concepto</td>
      <td bgcolor="#D8D8D8">Importe</td>
    </tr>
    <tr>
      <td>Impresora 3d</td>
      <td align="right">-205€</td>
    </tr>
    <tr>
      <td>Flores Jesús Expósito</td>
      <td align="right"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->
      <span data-sheets-value="{'1':3,'3':-165}" data-sheets-userformat="{'2':2563,'3':{'1':0},'4':{'1':2,'2':13369344},'12':0,'14':{'1':2,'2':16777215}}">-165</span>€</td>
    </tr>
  </tbody>
</table><h5>Gastos administrativos</h5><table width="400" border="0">
  <tbody>
    <tr>
      <td bgcolor="#D8D8D8">Concepto</td>
      <td bgcolor="#D8D8D8">Importe</td>
    </tr>
    <tr>
      <td>Mantenimiento tarjeta</td>
      <td align="right">-28€</td>
    </tr>
    <tr>
      <td>Seguros Allianz</td>
      <td align="right"><!--td {border: 1px solid #ccc;}br {mso-data-placement:same-cell;}-->
     -207,74€</td>
    </tr>
  </tbody>
</table></center>
	</div>
  <h4>Ingresos 2020</h4>	<div id="chartdiv2" style="width: 100%; height: 400px; background-color: #FFFFFF;" ></div>
    <h4>Crecimiento Club</h4>	<div id="chartdiv3" style="width: 100%; height: 400px;     background-color: rgb(68 68 68);" ></div>
</body>
</html>

