if(typeof hungama == 'undefined') {
	hungama = { };
} 

hungama.isMP3Supported = false;
var a = document.createElement('audio');
hungama.isMP3Supported = !!(a.canPlayType && a.canPlayType('audio/mpeg;').replace(/no/, ''));

hungama.Audio = function(url) {	
	this.isPlaying = false;
	this.audio = new Audio(url);
	//this.audio = document.getElementById('hplayer');
	//this.audio.src = url;
	this.audio.autoplay = true;
	this.duration = 0;
	this.onDurationChange = null;
	this.onPlaying = null;
	this.onEnd = null;
	this.elapsed = 0;
	var self = this;
	this.audio.addEventListener('canplay', function(_event) {
		this.play();
	});
	this.audio.addEventListener('durationchange', function(_event) {
		if(isNaN(this.duration) || this.duration == Number.POSITIVE_INFINITY) {
		} else {
			self.duration = this.duration;
			if(self.onDurationChange != null) {
				if(typeof self.onDurationChange == 'function') {
					self.onDurationChange(this.duration);
				}
			}
		}
	});
	this.audio.addEventListener('timeupdate', function(_event) {
		if(self.duration == 0) {
			if(isNaN(this.duration) || this.duration == Number.POSITIVE_INFINITY) {
			} else {
				self.duration = this.duration;
				if(self.onDurationChange != null) {
					if(typeof self.onDurationChange == 'function') {
						self.onDurationChange(this.duration);
					}
				}
			}
		}
		self.elapsed = this.currentTime;
		if(self.onPlaying != null) {
			if(typeof self.onPlaying == 'function') {
				self.onPlaying(this.currentTime);
			}
		}		
	});
	this.audio.addEventListener('ended', function(_event) {
		if(self.onEnd != null) {
			if(typeof self.onEnd == 'function') {
				self.onEnd(this.currentTime);
			}
		}				
	});
	if(navigator.userAgent.indexOf('BlackBerry') <= 0) {
		this.audio.play();								
	}
	//alert('Playing ..... ');
	//this.audio.play();
};

hungama.Audio.prototype.play = function() {
	this.audio.play();
};

hungama.Audio.prototype.pause = function() {
	this.audio.pause();
};


