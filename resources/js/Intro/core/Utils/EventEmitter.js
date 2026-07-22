export default class EventEmitter {
    constructor() {
        this.callbacks = {};
        this.callbacks.base = {};
    }

    on(_names, callback) {
        if (!_names || typeof callback !== "function") {
            return false;
        }

        const names = this.resolveNames(_names);

        names.forEach((name) => {
            if (!this.callbacks.base[name]) {
                this.callbacks.base[name] = [];
            }

            this.callbacks.base[name].push(callback);
        });

        return this;
    }

    off(_names) {
        if (!_names) {
            return false;
        }

        const names = this.resolveNames(_names);

        names.forEach((name) => {
            if (this.callbacks.base[name]) {
                delete this.callbacks.base[name];
            }
        });

        return this;
    }

    trigger(_name, args = []) {
        if (!_name) {
            return false;
        }

        const name = this.resolveNames(_name)[0];

        if (!this.callbacks.base[name]) {
            return null;
        }

        this.callbacks.base[name].forEach((callback) => {
            callback(...args);
        });

        return this;
    }

    resolveNames(names) {
        return names
            .replace(/[,/]+/g, " ")
            .split(" ")
            .filter((name) => name.length);
    }
}
