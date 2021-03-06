var EUTyreLabels = (function() {
    var scriptSrc = document.querySelector('script[src$="euTyreLabel.js"]').getAttribute('src');
    var name = scriptSrc.split('/').pop(); 
    var dir = scriptSrc.replace('/' + name, "");
    var allElements = [];
    var imgDirectory = dir + '/img/';
    var fuelArrowClass = 'eu-tyre-label-fuel-arrow';
    var rainArrowClass = 'eu-tyre-label-rain-arrow';
    var html = '<div class="eu-tyre-label-background"><div class="' + fuelArrowClass + ' eu-tyre-label-arrow"><img src="' + imgDirectory + 'arrow.png" alt="eu-tyre-label-fuel-arrow"><span class="eu-tyre-label-arrow-text">0</span></div><div class="' + rainArrowClass + ' eu-tyre-label-arrow"><img src="' + imgDirectory + 'arrow.png" alt="eu-tyre-label-rain-arrow"><span class="eu-tyre-label-arrow-text">0</span></div><div class="eu-tyre-label-noise-text"><img class="eu-tyre-label-noise-marker" alt="eu-tyre-label-noise-marker" src="img/markers/2.png"><span class="eu-tyre-label-noise-num">50</span><span class="eu-tyre-label-noise-db">dB</span></div></div>';

    var EuTyreLabel = function(obj, fuel, rain, noise) {
        if(!fuel || !rain || !noise) throw new Error('Required parameters on element with id: ' + obj.id + ' are missing');
        obj.innerHTML = html;
        this.htmlObj = obj;
        this.markerType = (noise < 69) ? 1 : (noise >= 69 && noise < 73) ? 2 : 3;
        this.addTyreClass(fuelArrowClass, fuel);
        this.addTyreClass(rainArrowClass, rain);
        this.htmlObj.querySelector('.eu-tyre-label-noise-num').innerHTML = noise;
        this.htmlObj.querySelector('.eu-tyre-label-noise-marker').src = imgDirectory + '/markers/' + this.markerType + '.png';
    };

    EuTyreLabel.prototype.allowedValues = ['a','b','c','d','e','f','g'];

    EuTyreLabel.prototype.addTyreClass = function(selector, type) {
        type = type.toString().toLowerCase();
        if(this.allowedValues.indexOf(type) !== -1){
            var arrow = this.htmlObj.getElementsByClassName(selector)[0];
            var arrowTxt = arrow.querySelector('.eu-tyre-label-arrow-text');
            arrowTxt.innerHTML = type.toUpperCase();
            arrow.classList.add('class-' + type);
            arrow.style.visibility = 'visible';
        }
    };

    document.addEventListener("DOMContentLoaded", function() {
        var labels = document.querySelectorAll('.eu-tyre-label');
        for(var index = 0, count = labels.length; index < count; index++) {
            var label = labels[index];
            var fuelAttr = label.attributes['data-fuel'];
            var rainAttr = label.attributes['data-rain'];
            var noiseAttr = label.attributes['data-noise'];
            var fuel = fuelAttr ? fuelAttr.value : null;
            var rain = rainAttr ? rainAttr.value : null;
            var noise = noiseAttr ? noiseAttr.value : null;
            label.id = 'eu-tyre-label-' + index;
            allElements.push(new EuTyreLabel(label, fuel, rain, noise));
        }
    });
    return allElements;
}());
