export function typewriter(text, speed = 80, callback = null) {
    return {
        full: text,
        displayed: "",
        index: 0,
        start() {
            const interval = setInterval(() => {
                if (this.index < this.full.length) {
                    this.displayed += this.full[this.index];
                    this.index++;
                } else {
                    clearInterval(interval);
                    if (callback) callback();
                }
            }, speed);
        },
    };
}
