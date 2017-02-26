$(function() {

    Morris.Area({
        element: 'morris-area-chart',
        data: [{
            period: '2010 Q1',
            iphone: 2666,
            ipad: null,
            itouch: 2647
        }, {
            period: '2010 Q2',
            iphone: 2778,
            ipad: 2294,
            itouch: 2441
        }, {
            period: '2010 Q3',
            iphone: 4912,
            ipad: 1969,
            itouch: 2501
        }, {
            period: '2010 Q4',
            iphone: 3767,
            ipad: 3597,
            itouch: 5689
        }, {
            period: '2011 Q1',
            iphone: 6810,
            ipad: 1914,
            itouch: 2293
        }, {
            period: '2011 Q2',
            iphone: 5670,
            ipad: 4293,
            itouch: 1881
        }, {
            period: '2011 Q3',
            iphone: 4820,
            ipad: 3795,
            itouch: 1588
        }, {
            period: '2011 Q4',
            iphone: 15073,
            ipad: 5967,
            itouch: 5175
        }, {
            period: '2012 Q1',
            iphone: 10687,
            ipad: 4460,
            itouch: 2028
        }, {
            period: '2012 Q2',
            iphone: 8432,
            ipad: 5713,
            itouch: 1791
        }],
        xkey: 'period',
        ykeys: ['iphone', 'ipad', 'itouch'],
        labels: ['iPhone', 'iPad', 'iPod Touch'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });

    Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "PO Created",
            value: 12
        }, {
            label: "GRN",
            value: 30
        }, {
            label: "TOTAL",
            value: 20
        }],
        resize: true
    });
    <?php  $inv_dt = time();
        $inv_last_dt = date('t');
        $today = $inv_dt;
        $this_yr = strtotime(date("Y", $today)."-04-01");
        $nxt_yr = strtotime((date("Y", $today)+1)."-03-31");
        $this_yr = strtotime(date("Y", $today)."-04-01");
        $nxt_yr = strtotime((date("Y", $today)+1)."-03-31");

        if($today > strtotime(date("Y", $today)."-04-01") && $today < strtotime((date("Y", $today)+1)."-03-31")){
            $FinYr = date('y', $today)."-".(date('y', $today)+1);
            $FinYr2 = date('y',$today)-1."-".(date('y',$today));
     }?>
    Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: '<?php echo $FinYr2;?>',
            a: 100,
            b: 90
        }, {
            y: '<?php echo $FinYr;?>',
            a: 75,
            b: 65
        }, {
            y: '2008',
            a: 50,
            b: 40
        }, {
            y: '2009',
            a: 75,
            b: 65
        }, {
            y: '2012',
            a: 100,
            b: 90
        }],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B'],
        hideHover: 'auto',
        resize: true
    });
    
});
