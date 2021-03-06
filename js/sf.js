function StringBuffer() {

	var buffer = []; // 存放字符串数组
	var size = 0; // 存放数组大小

	// 追加字符串
	this.append = function(s) {
		if (s != null) {
			buffer.push(s);
			size++;
		}
	}

	// 返回字符串
	this.toString = function() {
		return buffer.join("");
	}

	// 清空
	this.clear = function(key) {
		size = 0;
		buffer = [];
	}

	// 返回数组大小
	this.size = function() {
		return size;
	}

	// 返回数组
	this.toArray = function() {
		return buffer;
	}

	// 倒序返回字符串
	this.doReverse = function() {
		var str = buffer.join('');
		str = str.split('');
		return str.reverse().join('');
	}
}