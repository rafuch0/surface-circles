<?php
if (isset($_GET['3141592654'])) die(highlight_file(__FILE__, 1));

function getPageJS($canvas, $width, $height)
{
	$output = '';

	$output .= '<script src="surface.js"></script>';

	$output .= '<script>';

	$output .= "var canvas = '$canvas';";
	$output .= "var width = '$width';";
	$output .= "var height = '$height';";

	$output .= <<< 'EOD'

var d;
var xPoint;
var yPoint;
var color = '0xFF0000';

function drawCircle(centerX, centerY, radius)
{
	d = 3 - (2 * radius);
	xPoint = 0;
	yPoint = radius;

	while(xPoint <= yPoint)
	{
		Surface.plot(centerX + xPoint, centerY + yPoint, color);
		Surface.plot(centerX + xPoint, centerY - yPoint, color);
		Surface.plot(centerX - xPoint, centerY + yPoint, color);
		Surface.plot(centerX - xPoint, centerY - yPoint, color);
		Surface.plot(centerX + yPoint, centerY + xPoint, color);
		Surface.plot(centerX + yPoint, centerY - xPoint, color);
		Surface.plot(centerX - yPoint, centerY + xPoint, color);
		Surface.plot(centerX - yPoint, centerY - xPoint, color);

		if(d < 0)
		{
			d = d + (4 * xPoint) + 6;
		}
		else
		{
			d = d + 4 * (xPoint - yPoint) + 10;
			yPoint--;
		}

		xPoint++;
	}
}

var rad;
var xPt;
var yPt;

function circleLoop()
{
	rad = Math.floor(Math.random() * 20) + 5;
	xPt = Math.floor(Math.random() * (width - (rad * 2))) + Math.floor(rad / 2);
	yPt = Math.floor(Math.random() * (height - (rad * 2))) + Math.floor(rad / 2);

	drawCircle(xPt, yPt, rad);

	Surface.render();
}

function main(canvas, width, height, mainFunc, loopFunc)
{
	var canvasContext = document.getElementById(canvas);

	Surface.init(canvasContext, width, height);

	Surface.loop(loopFunc, 60);
}

main(canvas, width, height, circleLoop, circleLoop);

EOD;
	$output .= '</script>';

	return $output;
}

function getPageHTML($canvas, $width, $height)
{
	$output = '';

	$output .= '<!DOCTYPE html>';
	$output .= '<html>';

		$output .= '<head>';

		$output .= '</head>';

		$output .= '<body>';

		$output .= '<canvas id="'.$canvas.'" width="'.$width.'" height="'.$height.'">';
		$output .= 'herp derp nice browser';
		$output .= '</canvas>';

		$output .= getPageJS($canvas, $width, $height);

		$output .= '</body>';

	$output .= '</html>';

	return $output;
}

$output = '';

$output .= getPageHTML('canvas', 1024, 768);

echo $output;

?>
