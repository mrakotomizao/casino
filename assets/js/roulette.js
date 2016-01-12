var colors = ["#2b2b2b", "#e0a617", "#2b2b2b", "#e0a617", "#2b2b2b", "#e0a617", "#2b2b2b", "#e0a617", "#3a5c25", "#e0a617", "#2b2b2b", "#e0a617"];
var restaraunts = [17, 32, 15, 19, 4, 21, 2, 25, 0, 34, 6, 27];

var startAngle = 0;
var arc = Math.PI / 6;
var spinTimeout = null;

var spinArcStart = 10;
var spinTime = 0;
var spinTimeTotal = 0;
var totalAction = 0;

var ctx;

function draw() {
    drawRouletteWheel();
}

function drawRouletteWheel() {
    var canvas = document.getElementById("wheelcanvas");
    if (canvas.getContext) {
        var outsideRadius = 165;
        var textRadius = 120;
        var insideRadius = 100;

        ctx = canvas.getContext("2d");
        ctx.clearRect(0, 0, 500, 500);


        ctx.strokeStyle = "black";
        ctx.lineWidth = 2;

        ctx.font = 'bold 22px sans-serif';

        for (var i = 0; i < 12; i++) {
            var angle = startAngle + i * arc;
            ctx.fillStyle = colors[i];

            ctx.beginPath();
            ctx.arc(250, 250, outsideRadius, angle, angle + arc, false);
            ctx.arc(250, 250, insideRadius, angle + arc, angle, true);
            ctx.stroke();
            ctx.fill();

            ctx.save();
            ctx.shadowOffsetX = -1;
            ctx.shadowOffsetY = -1;
            ctx.shadowBlur = 0;
            ctx.shadowColor = "rgb(220,220,220)";
            ctx.fillStyle = "black";
            ctx.translate(250 + Math.cos(angle + arc / 2) * textRadius, 250 + Math.sin(angle + arc / 2) * textRadius);
            ctx.rotate(angle + arc / 2 + Math.PI / 2);
            var text = restaraunts[i];
            ctx.fillText(text, -ctx.measureText(text).width / 2, 0);
            ctx.restore();
        }

        //Arrow
        ctx.fillStyle = "black";
        ctx.beginPath();
        ctx.moveTo(250 - 4, 250 - (outsideRadius + 5));
        ctx.lineTo(250 + 4, 250 - (outsideRadius + 5));
        ctx.lineTo(250 + 4, 250 - (outsideRadius - 5));
        ctx.lineTo(250 + 9, 250 - (outsideRadius - 5));
        ctx.lineTo(250 + 0, 250 - (outsideRadius - 13));
        ctx.lineTo(250 - 9, 250 - (outsideRadius - 5));
        ctx.lineTo(250 - 4, 250 - (outsideRadius - 5));
        ctx.lineTo(250 - 4, 250 - (outsideRadius + 5));
        ctx.fill();
    }
}

function spin() {
    var nbaction = parseInt($("#nbaction").text());
    var fbId = parseInt($("#fbId").attr('value'));

    $.ajax({
        type: "POST",
        url: 'roulette/ajaxGetNbAction',
        data: {
            'fbid': fbId
        },
        dataType: 'json',
        success: function (response) {
            totalAction = response;
            console.log(totalAction);
            if (totalAction < 3) {
                spinAngleStart = Math.random() * 10 + 10;
                spinTime = 0;
                spinTimeTotal = Math.random() * 3 + 4 * 1000;
                rotateWheel();
            } else {
                alert("Vous n'avez plus d'action pour aujourd'hui");
            }
        },
        error: function () {
            console.log('failure');
        }
    });
}

function rotateWheel() {
    spinTime += 30;
    if (spinTime >= spinTimeTotal) {
        stopRotateWheel();
        return;
    }
    var spinAngle = spinAngleStart - easeOut(spinTime, 0, spinAngleStart, spinTimeTotal);
    startAngle += (spinAngle * Math.PI / 180);
    drawRouletteWheel();
    spinTimeout = setTimeout('rotateWheel()', 30);
}

function stopRotateWheel() {
    clearTimeout(spinTimeout);
    var degrees = startAngle * 180 / Math.PI + 90;
    var arcd = arc * 180 / Math.PI;
    var index = Math.floor((360 - degrees % 360) / arcd);
    ctx.save();
    ctx.font = 'bold 50px sans-serif';
    var text = restaraunts[index]
    ctx.fillText(text, 250 - ctx.measureText(text).width / 2, 250 + 10);
    ctx.restore();


    setProgressBar(text);
}
function setProgressBar(value) {
    var total = $("#total").attr('value');
    var fbId = parseInt($("#fbId").attr('value'));
    var nbaction = $("#nbaction").text();

    var value = parseInt(value);
    $.ajax({
        type: "POST",
        url: 'roulette/setPoint',
        data: {
            'value': value,
            'iduser': fbId
        },
        dataType: 'json',
        success: function (msg) {
            if (typeof msg.error == "undefined") {
                getRanking(value);
                $("#total").attr('value', parseInt(total) + parseInt(value));
                //On recupère le nombre de point quotidien
                getDailyPoint(fbId);

                $("#nbaction").text(parseInt(nbaction) - 1);
            } else {
                alert(msg.error);
            }
        },
        error: function () {
            console.log('failure');
        }
    });


}


function getRanking(value) {
    var currProgress = $("#redbar").attr('value');
    var total = $("#total").attr('value');
    var progress = parseInt(currProgress) + parseInt(value);

    if (progress > $("#redbar").attr('max')) {

        var currentRank = "";
        var realVal = parseInt(total) + parseInt(value);

        console.log(realVal);
        $.ajax({
            type: "POST",
            url: 'roulette/getRanking',
            async: false,
            data: {
                'total': realVal
            },
            dataType: 'json',
            success: function (response) {
                currentRank = response;
            },
            error: function () {
                console.log('failure');
            }
        });
        var barvalue = Math.abs(parseInt(currentRank.min) - realVal);
        $("#redbar").attr('value', barvalue);
        console.log(currentRank.id_rang);
        $("#niv").text("Niv." + currentRank.id_rang);
        $("#redbar").attr('max', currentRank.max - currentRank.min);
    } else {
        $("#redbar").attr('value', parseInt(currProgress) + parseInt(value));
    }
}
function getDailyPoint() {
    var fbId = parseInt($("#fbId").attr('value'));

    $.ajax({
        type: "POST",
        url: 'roulette/getDailyPoint',
        data: {
            'fbid': fbId
        },
        dataType: 'json',
        success: function (response) {
            console.log(response[0]);
            $("#dailyTotal").text(response[0].valeur);
        },
        error: function () {
            console.log('failure');
        }
    });
}
function easeOut(t, b, c, d) {
    var ts = (t /= d) * t;
    var tc = ts * t;
    return b + c * (tc + -3 * ts + 3 * t);
}

draw();