/*
��_off�פȡ�_over�פȤ���̾�����ޤޤ�륤�᡼���ե����������Ѱա�
��_off�פ��̾�Υ��᡼���Ȥʤꡢ�ޥ��������С�����ȡ�_over�פΥ��᡼���ե������
�����Ѥ��ޤ����ޥ����򳰤��ȡ�_off�פβ��������ޤ���
Ex.) ���᡼���ե������menu1_off.gif�ס� menu1_over.gif��
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
			ovrImgList[i].onmouseover = function() { // �ޥ��������С�
				this.src = this.src.replace(/_off\./i, '_over.');
			}
			ovrImgList[i].onmouseout = function() { // �ޥ���������
				this.src = this.src.replace(/_over\./i, '_off.');
			}
			if (navigator.userAgent.indexOf('MSIE') < 0) ovrImgList[i].onmouseup = function() { // ����å���Υ��륪���С����
				this.src = this.src.replace(/_over\./i, '_off.');
			}
		}
	}
	return true;
}
if (window.addEventListener) window.addEventListener('load', setRollOver, false);
if (window.attachEvent) window.attachEvent('onload', setRollOver);
