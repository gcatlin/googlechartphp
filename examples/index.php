<?php require dirname(__FILE__).'/../GoogleChart.php'; ?>
<html>
	<head>
		<title>GoogleChartPHP Examples</title>
	</head>
	<body>
		<h1>Examples</h1>
		<ul>
			<li><a href="#basics">Basics</a></li>
			<li><a href="#line-charts">Line Charts</a></li>
			<li><a href="#bar-charts">Bar Charts</a></li>
			<li><a href="#pie-charts">Pie Charts</a></li>
			<li><a href="#venn-diagrams">Venn Diagrams</a></li>
			<li><a href="#scatter-plots">Scatter Plots</a></li>
			<li><a href="#radar-charts">Radar Charts</a></li>
			<li><a href="#pie-charts">Pie Charts</a></li>
			<li><a href="#maps">Maps</a></li>
			<li><a href="#google-o-meter">Google-o-meter</a></li>
			<li><a href="#qr-codes">QR Codes</a></li>
		</ul>

		<h2 name="basics">Basics</h2>
		<h3>Instantiation</h3>
		<code>
			// sorry, you can't do this
			$chart = new GoogleChart();

			// theses are equivalent
			$chart = new GoogleChart_LineChart();
			$chart = GoogleChart::LineChart();
		</code>

		<h3>Parameters</h3>
		<code>
			// these are all equivalent
			$data = array(1, 2, 3);

			$chart = new GoogleChart_LineChart($data);
			$chart = GoogleChart::LineChart($data);

			$chart = GoogleChart::LineChart()->data($data);
		</code>


		<h2 name="line-charts">Line Charts</h2>
		<h3>Simple</h3>
		<img src="<?php echo GoogleChart::LineChart(array(80,50,30,20,10), array(200,100))->url(); ?>">
		<code>
			print GoogleChart::LineChart(array(80,50,30,20,10), array(200,100))->img();
		</code>

		<h2 name="bar-charts">Bar Charts</h2>
		<h3>Simple</h3>
		<img src="<?php echo GoogleChart::BarChart(array(80,50,30,20,10), array(200,100))->url(); ?>">
		<code>
			print GoogleChart::BarChart(array(80,50,30,20,10), array(200,100))->img();
		</code>

		<h2 name="pie-charts">Pie Charts</h2>
		<h3>Simple</h3>
		<img src="<?php echo GoogleChart::PieChart(array(80,50,30,20,10), array(200,100))->url(); ?>">
		<code>
			print GoogleChart::PieChart(array(210,130,80,50,30,20,10), array(200,100))->img();
		</code>

		<h2 name="venn-diagrams">Venn Diagrams</h2>
		<h3>Simple</h3>
		<img src="<?php echo GoogleChart::VennDiagram(array(210,130,80,50,30,20,10), array(200,100))->url(); ?>">
		<code>
			print GoogleChart::VennDiagram(array(130,80,50,30,20,10,10), array(200,100))->img();
		</code>

		<h2 name="scatter-plots">Scatter Plots</h2>
		<h3>Simple</h3>
		<img src="<?php echo GoogleChart::ScatterPlot(array(array(80,50,30), array(20,10,10)), array(200,100))->url(); ?>">
		<code>
			print GoogleChart::ScatterPlot(array(array(80,50,30), array(20,10,10)), array(200,100))->img();
		</code>

		<h2 name="radar-charts">Radar Charts</h2>
		<h3>Simple</h3>
		<img src="<?php echo GoogleChart::RadarChart(array(80,50,30,20,10), array(200,100))->url(); ?>">
		<code>
			print GoogleChart::RadarChart(array(80,50,30,20,10), array(200,100))->img();
		</code>

		<h2 name="maps">Maps</h2>
		<h3>Simple</h3>
		<img src="<?php echo GoogleChart::Map(array(80,50,30,20,10), array(200,100))->url(); ?>">
		<code>
			print GoogleChart::Map(array(80,50,30,20,10), array(200,100))->img();
		</code>

		<h2 name="google-o-meter">Googleometers</h2>
		<h3>Simple</h3>
		<img src="<?php echo GoogleChart::Googleometer(array(80), array(200,100))->url(); ?>">
		<code>
			print GoogleChart::Googleometer(array(80), array(200,100))->img();
		</code>

		<h2 name="qr-codes">QR Codes</h2>
		<h3>Simple</h3>
		<img src="<?php echo GoogleChart::QRCode(array(80,50,30,20,10), array(200,100))->url(); ?>">
		<code>
			print GoogleChart::QRCode(array(80,50,30,20,10), array(200,100))->img();
		</code>

	</body>
</html>
	