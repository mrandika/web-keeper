import './bootstrap';

const Turbolinks = require("turbolinks")
Turbolinks.start()

Turbolinks.BrowserAdapter.prototype.showProgressBarAfterDelay = function() {
    return this.progressBarTimeout = setTimeout(this.showProgressBar, 100);
};
