@extends('layout.master')

@section('title','admin panel')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
<h4 class="fw-bold">داشبورد</h4></div>
<div id="chartdiv"></div>
@endsection

@section('script')
 <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

    <script>
        am5.ready(function () {

            // Create root element
            // https://www.amcharts.com/docs/v5/getting-started/#Root_element
            var root = am5.Root.new("chartdiv");


            // Set themes
            // https://www.amcharts.com/docs/v5/concepts/themes/
            root.setThemes([
                am5themes_Animated.new(root)
            ]);


            // Create chart
            // https://www.amcharts.com/docs/v5/charts/xy-chart/
            var chart = root.container.children.push(am5xy.XYChart.new(root, {
                panX: true,
                panY: true,
                wheelX: "panX",
                wheelY: "zoomX",
                pinchZoomX: true
            }));

            // Add cursor
            // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
            var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
            cursor.lineY.set("visible", false);


            // Create axes
            // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
            var xRenderer = am5xy.AxisRendererX.new(root, { minGridDistance: 30 });
            xRenderer.labels.template.setAll({
                rotation: -90,
                centerY: am5.p50,
                centerX: am5.p100,
                paddingRight: 15,
                direction: "rtl",
                fontFamily: "Vazir"
            });
            var yRenderer = am5xy.AxisRendererY.new(root, {});
            yRenderer.labels.template.setAll({
                direction: "rtl",
                fontFamily: "Vazir"
            });

            var xtooltipRtl = am5.Tooltip.new(root, {})
            xtooltipRtl.label.setAll({
                direction: "rtl",
                fontFamily: "Vazir"
            })

            var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                maxDeviation: 0.3,
                categoryField: "month",
                renderer: xRenderer,
                tooltip: xtooltipRtl,
            }));

            var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                maxDeviation: 0.3,
                renderer: yRenderer
            }));

            var tooltipRtl = am5.Tooltip.new(root, {
                labelText: "{valueY}"
            })
            tooltipRtl.label.setAll({
                direction: "rtl",
                fontFamily: "Vazir"
            })
            // Create series
            // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
            var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                name: "Series 1",
                xAxis: xAxis,
                yAxis: yAxis,
                valueYField: "value",
                sequencedInterpolation: true,
                categoryXField: "month",
                tooltip: tooltipRtl
            }));

            series.columns.template.setAll({ cornerRadiusTL: 5, cornerRadiusTR: 5 });
            series.columns.template.adapters.add("fill", function (fill, target) {
                return chart.get("colors").getIndex(series.columns.indexOf(target));
            });

            series.columns.template.adapters.add("stroke", function (stroke, target) {
                return chart.get("colors").getIndex(series.columns.indexOf(target));
            });


            // Set data
            var data = @json($data);
            // [{
            //     month: "فروردین",
            //     value: 2025
            // }, {
            //     month: "اردیبهشت",
            //     value: 1882
            // }, {
            //     month: "خرداد",
            //     value: 1809
            // }, {
            //     month: "تیر",
            //     value: 1722
            // }, {
            //     month: "مرداد",
            //     value: 1522
            // }, {
            //     month: "شهریور",
            //     value: 1414
            // }, {
            //     month: "مهر",
            //     value: 1120
            // }, {
            //     month: "آبان",
            //     value: 998
            // }, {
            //     month: "آذر",
            //     value: 875
            // }, {
            //     month: "دی",
            //     value: 789
            // }, {
            //     month: "بهمن",
            //     value: 658
            // }, {
            //     month: "اسنفد",
            //     value: 598
            // }];

            xAxis.data.setAll(data);
            series.data.setAll(data);


            // Make stuff animate on load
            // https://www.amcharts.com/docs/v5/concepts/animations/
            series.appear(1000);
            chart.appear(1000, 100);

        }); // end am5.ready()
    </script>
@endsection