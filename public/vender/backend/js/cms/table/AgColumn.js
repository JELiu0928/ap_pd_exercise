import { typeSet } from "./typeSet.js";

/**
 * @param {Array<string>} role
 * @returns {AgColumn}
 */
export class AgColumn {

    #setting = {};
    options;
    agControl;
    role;

    constructor(agControl, role) {
        this.agControl = agControl;
        this.role = role;
    }

    setGroup(bool) {
        this.#setting.enableRowGroup = bool;
        return this;
    }

    /** Set column value resource */
    setField(field) {
        this.#setting.field = field;
        return this;
    }

    /** Set column display header */
    setHeaderName(headerName) {
        this.#setting.headerName = headerName;
        return this;
    }

    setHide(hide) {
        this.#setting.hide = hide;
        return this;
    }

    setResize(resizable) {
        this.#setting.resizable = resizable;
        return this;
    }

    setOverflow(wrapText) {
        this.#setting.wrapText = wrapText;
        return this;
    }

    setType(type) {
        if (type != null && type in typeSet) {
            const sets = typeSet[type](this.agControl, this.role, this);
            for (const key of Object.keys(sets)) {
                this.#setting[key] = sets[key];
            };
        }
        return this;
    }

    setOptions(options) {
        this.options = options;

        return this;
    }

    setWidth(width) {
        if (width) {
            this.#setting.width = width;
        }
        return this;
    }
    setFlex(flex,width) {
        if (flex) {
            this.#setting.flex = 1;
            this.#setting.minWidth = width;
        }
        return this;
    }

    /** @returns  */
    get() {
        return this.#setting;
    }
}

/**
 * @param {object} role
 * @returns {AgColumn}
 */
export function defineColumn(agControl, role, { field, headerName = null, type = null, width = null, options = [], group = false ,flex=true } = {}) {
    return new AgColumn(agControl, role)
        .setHeaderName(headerName || field)
        .setOptions(options || [])
        // .setWidth(width || 0)
        .setType(type)
        .setField(field)
        .setGroup(group)
        .setFlex(flex,width);
}