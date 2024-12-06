function emptyNotRequired(val, options) {
    return !('required' in options) && (val === '' || val == null || val === 'null');
}

function isVaildJSON(val, options) {
    try{
        val.replace('/s/g',"");
        JSON.parse(val);
        return true;
    }catch(e){
        console.log(e.name+ ' ' + e.message);
        return false;
    }
}

export const verifySet = {
    required: {
        check(val, options, editArea) {
            return /^.+$/.test(val) && val != null && val != 'null';
        },
        meg(field, options, editArea) {
            return `${field} 為必填欄位`
        }
    },
    requiredIf: {
        check(val, options, editArea) {
            const columns = Object.keys(options.requiredIf ?? {});
            let required = false;
            for (const col of columns) {
                required = editArea.find(`[name="${col}"]`).val() === options.requiredIf[col];
                if (required) break;
            }

            if (required) {
                return verifySet.required.check(val, options, editArea);
            } else {
                return true;
            }
        },
        meg(field, options, editArea) {
            return `${field} 為必填欄位`
        }
    },
    include: {
        check(val, options, editArea) {
            if (emptyNotRequired(val, options)) return true;
            const includes = Array.from(options.include ?? []);
            let result = true;
            for (const include of includes) {
                result = val.indexOf(include) !== -1;
                if (!result) break;
            }
            return result;
        },
        meg(field, options, editArea) {
            const includes = Array.from(options.include ?? []).map((i) => `"${i}"`).join(' & ');
            return `${field} 必須包含： ${includes}`;
        }
    },
    except: {
        check(val, options, editArea) {
            if (emptyNotRequired(val, options)) return true;
            const excepts = Array.from(options.except ?? []);
            let result = true;
            for (const except of excepts) {
                result = val.indexOf(except) === -1;
                if (!result) break;
            }
            return result;
        },
        meg(field, options, editArea) {
            const excepts = Array.from(options.except ?? []).map((i) => `"${i}"`).join(' | ');
            return `${field} 不可包含： ${excepts}`;
        }
    },
    unique: {
        check(val, options, editArea) {
            const exists = Array.from(options.unique ?? []);
            return !exists.includes(val);
        },
        meg(field, options, editArea) {
            return `${field} 內容重複`
        }
    },
    in: {
        check(val, options, editArea) {
            const exists = Array.from(options.in ?? []);
            return exists.includes(val);
        },
        meg(field, options, editArea) {
            const str = Array.from(options.in ?? []).map((i) => `"${i}"`).join(' | ');
            return `${field} 未在選項之中： ${str}`;
        }
    },
    maxLength: {
        check(val, options, editArea) {
            if (emptyNotRequired(val, options)) return true;
            const max = parseInt(options.maxLength) || Number.MAX_VALUE;
            return val.length <= max;
        },
        meg(field, options, editArea) {
            const max = parseInt(options.maxLength) || Number.MAX_VALUE;
            return `${field} 內容長度必須小於： ${max}`;
        }
    },
    minLength: {
        check(val, options, editArea) {
            if (emptyNotRequired(val, options)) return true;
            const min = parseInt(options.minLength) || 0;
            return val.length >= min;
        },
        meg(field, options, editArea) {
            const min = parseInt(options.minLength) || 0;
            return `${field} 內容長度必須大於： ${min}`;
        }
    },
    maxNumber: {
        check(val, options, editArea) {
            if (emptyNotRequired(val, options)) return true;
            const max = parseInt(options.maxNumber) || Number.MAX_VALUE;
            const value = parseInt(val);
            return !isNaN(value) && value <= max;
        },
        meg(field, options, editArea) {
            const max = parseInt(options.maxNumber) || Number.MAX_VALUE;
            return `${field} 必須是數字且小於： ${max}`;
        }
    },
    minNumber: {
        check(val, options, editArea) {
            if (emptyNotRequired(val, options)) return true;
            const min = parseInt(options.minNumber) || 0;
            const value = parseInt(val);
            return !isNaN(value) && value >= min;
        },
        meg(field, options, editArea) {
            const min = parseInt(options.minNumber) || 0;
            return `${field} 必須是數字且大於： ${min}`;
        }
    },
    number: {
        check(val, options, editArea) {
            if (emptyNotRequired(val, options)) return true;
            const value = parseInt(val);
            return !isNaN(value);
        },
        meg(field, options, editArea) {
            return `${field} 必須是數字`;
        }
    },
    email: {
        check(val, options) {
            if (emptyNotRequired(val, options)) return true;
            return /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(val);
        },
        meg(field, options, editArea) {
            return `${field} 必須是郵件信箱格式`;
        }
    },
    json: {
        check(val, options) {
            if(emptyNotRequired(val, options)) return true;
            if(isVaildJSON(val, options)) return true;
        },
        meg(field, options, editArea) {
            return `${field} 必須是JSON格式，例如: { "name" : "value" }`;
        }
    },
}