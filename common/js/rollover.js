/*
「_off」と「_over」という名前が含まれるイメージファイルを二つ用意。
「_off」が通常のイメージとなり、マウスオーバーすると「_over」のイメージファイルに
入れ変わります。マウスを外すと「_off」の画像に戻ります。
Ex.) イメージファイル「menu1_off.gif」「 menu1_over.gif」
<img src="menu1_off.gif" />
*/
function setRollOver() {
	var loadedImg = new Array();
	if (!document.getElementsByTagName) return false;
	var ovrImgList = document.getElementsByTagName('img');
	for (var i = 0; i < ovrImgList.length; i++) {
		if (ovrImgList[i].src.match(/_off\./i)) {
			loadedImg[i] = new Image();
			loadedImg[i].src = ovrImgList[i].src.replace(/_off\./i, '_over.');
			ovrImgList[i].onmouseover = function() { // マウスオーバー
				this.src = this.src.replace(/_off\./i, '_over.');
			}
			ovrImgList[i].onmouseout = function() { // マウスアウト
				this.src = this.src.replace(/_over\./i, '_off.');
			}
			if (navigator.userAgent.indexOf('MSIE') < 0) ovrImgList[i].onmouseup = function() { // クリック後のロールオーバー解除
				this.src = this.src.replace(/_over\./i, '_off.');
			}
		}
	}
	return true;
}
if (window.addEventListener) window.addEventListener('load', setRollOver, false);
if (window.attachEvent) window.attachEvent('onload', setRollOver);
