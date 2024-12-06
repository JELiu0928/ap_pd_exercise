import { dateCompare } from "./compare.js";
import RadioButtonCol from "./rederer/RadioButtonCol.js";
import EditButtonCol from "./rederer/EditButtonCol.js";
import ImageCol from "./rederer/ImageCol.js";
import RadioButtonFilter from "./rederer/RadioButtonFilter.js";
import SelectFilter from "./rederer/SelectFilter.js";
import SelectMultiFilter from "./rederer/SelectMultiFilter.js";
import ColorCol from "./rederer/ColorCol.js";
import LongTextCol from "./rederer/LongTextCol.js";

var months = [
    "01",
    "02",
    "03",
    "04",
    "05",
    "06",
    "07",
    "08",
    "09",
    "10",
    "11",
    "12",
];
/**
 * HTML字串轉dom
 * @param {string} htmlString HTML 字串
 * @returns
 */
function htmlStringToDOM(htmlString) {
    var dom = document.createElement("div");
    dom.innerHTML = htmlString;
    return dom.childNodes[0];
}

export const typeSet = {
    blankCol: (agControl, role, col) => {
        return {
            initialPinned: "left",
            suppressMovable: true,
            lockPinned: true,
            resizable: false,
            filter: false,
            menuTabs: [],
            sortable: false,
            maxWidth: 10,

            suppressCellFocus: true,
            cellClass: () => {
                return "blank-field";
            },
            cellStyle: {
                'pointer-events': 'none',
            }
        };
    },
    checkbox: (agControl, role, col) => {
        return {
            headerCheckboxSelection: true,
            headerCheckboxSelectionFilteredOnly: true,
            checkboxSelection: true,
            lockPosition: "left",
            resizable: false,
            width: 50,
            maxWidth: 50,
        };
    },
    drag: (agControl, role, col) => {
        return {
            initialPinned: "left",
            suppressMovable: true,
            lockPinned: true,
            rowDrag: true,
            resizable: false,
            width: 50,
            maxWidth: 50,
            filter: false,
            menuTabs: [],
            sortable: false,

        };
    },
    edit: (agControl, role, col) => {
        return {
            initialPinned: "left",
            suppressMovable: true,
            lockPinned: true,
            resizable: false,
            width: 50,
            maxWidth: 50,
            filter: false,
            menuTabs: [],
            sortable: false,
            cellRenderer: EditButtonCol(agControl, role, col),
        };
    },
    TextCol: (agControl, role, col) => {
        return {
            lockPinned: true,
            filter: role.filter ? "agTextColumnFilter" : false,
            filterParams: {
                buttons: ["clear"],
            },
            menuTabs: role.filter ? ["filterMenuTab"] : [],
        };
    },
    LongTextCol: (agControl, role, col) => {
        return {
            lockPinned: true,
            filter: role.filter ? "agTextColumnFilter" : false,
            filterParams: {
                buttons: ["clear"],
            },
            menuTabs: role.filter ? ["filterMenuTab"] : [],
            cellRenderer: LongTextCol(agControl, role, col),
        };
    },
    DateCol: (agControl, role, col) => {
        return {
            lockPinned: true,
            filter: role.filter ? "agDateColumnFilter" : false,
            menuTabs: role.filter ? ["filterMenuTab"] : [],
            filterParams: {
                comparator: dateCompare,
                inRangeInclusive: true,
                filterOptions: [
                    "equals",
                    "notEqual",
                    "lessThan",
                    "greaterThan",
                    "inRange",
                ],
                buttons: ["clear"],
            },
        };
    },
    TimestampCol: (agControl, role, col) => {
        return {
            lockPinned: true,
            valueFormatter: (params) => {
                if (params.value == null) return "";
                let date = new Date(params.value);
                return (
                    `${date.getFullYear()}-${months[date.getMonth()]}-${date.getDate() > 9
                        ? date.getDate()
                        : "0" + date.getDate()
                    }` +
                    `\n${date.getHours() > 9
                        ? date.getHours()
                        : "0" + date.getHours()
                    }：${date.getMinutes() > 9
                        ? date.getMinutes()
                        : "0" + date.getMinutes()
                    }：${date.getSeconds() > 9
                        ? date.getSeconds()
                        : "0" + date.getSeconds()
                    }`
                );
            },
            filter: role.filter ? "agDateColumnFilter" : false,
            menuTabs: role.filter ? ["filterMenuTab"] : [],
            filterParams: {
                comparator: dateCompare,
                inRangeInclusive: true,
                filterOptions: [
                    "equals",
                    "notEqual",
                    "lessThan",
                    "greaterThan",
                    "inRange",
                ],
                buttons: ["clear"],
            },
            cellStyle: () => {
                return { "white-space": "pre" };
            },
        };
    },
    NumberCol: (agControl, role, col) => {
        return {
            lockPinned: true,
            filter: role.filter ? "agNumberColumnFilter" : false,
            menuTabs: role.filter ? ["filterMenuTab"] : [],
            filterParams: {
                allowedCharPattern: "\\d\\-\\,",
                numberParser: (text) => {
                    return text == null
                        ? null
                        : parseFloat(text.replace(",", "."));
                },
                buttons: ["clear"],
            },
            cellStyle: () => {
                return { "text-align": "center" };
            },
        };
    },
    NumberInputCol: (agControl, role, col) => {
        return {
            lockPinned: true,
            editable: role.edit,
            valueParser: (params) => {
                return parseInt(params.newValue) || 0;
            },
            filter: role.filter ? "agNumberColumnFilter" : false,
            menuTabs: role.filter ? ["filterMenuTab"] : [],
            filterParams: {
                allowedCharPattern: "\\d\\-\\,",
                numberParser: (text) => {
                    return text == null
                        ? null
                        : parseFloat(text.replace(",", "."));
                },
                buttons: ["clear"],
            },
            cellStyle: () => {
                return { "text-align": "center" };
            },
        };
    },
    RankInputCol: (agControl, role, col) => {
        return {
            lockPinned: true,
            singleClickEdit:true,
            editable: role.edit,
            valueParser: (params) => {
                let val = parseInt(params.newValue) || 0;
                return val > 0 ? val : 0;
            },
            filter: false,
            menuTabs: [],
            cellStyle: () => {
                return { "text-align": "center" };
            },
            cellClass: () => {
                return role.edit ? "text_editable" : "";
            },
            cellRenderer: function(params) {
                return '<div style="display: flex;align-items: center;gap: 10px;"><svg style="height:12px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1 0 32c0 8.8 7.2 16 16 16l32 0zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"/></svg><span>' + params.value + '</span></div>'
            }
        };
    },
    RadioButtonCol: (agControl, role, col) => {
        return {
            lockPinned: true,
            filter: role.filter
                ? RadioButtonFilter(agControl, role, col)
                : false,
            menuTabs: role.filter ? ["filterMenuTab"] : [],
            cellRenderer: RadioButtonCol(agControl, role, col),
        };
    },
    SelectMultiCol: (agControl, role, col) => {

        return {
            lockPinned: true,
            valueFormatter: (params) => {
                if (params.value == null || params.value == "") {
                    return "";
                }

                return Array.from(JSON.parse(params.value) || [])
                    .reduce((res, cur) => {
                        const opt = col.options[cur]?.title || "";
                        if (opt.length > 0) {
                            res.push(opt);
                        }
                        return res;
                    }, [])
                    .join(" ,\n");
            },
            cellStyle: () => {
                return { "white-space": "pre" };
            },
            filter: role.filter
                ? SelectMultiFilter(agControl, role, col)
                : false,
            menuTabs: role.filter ? ["filterMenuTab"] : [],
        };
    },
    SelectCol: (agControl, role, col) => {
        return {
            lockPinned: true,
            valueFormatter: (params) => {
                return col.options[params.value]?.title || "";
            },
            filter: role.filter ? SelectFilter(agControl, role, col) : false,
            menuTabs: role.filter ? ["filterMenuTab"] : [],
        };
    },
    ImageCol: (agControl, role, col) => {
        return {
            lockPinned: true,
            filter: false,
            menuTabs: [],
            sortable: false,
            cellRenderer: ImageCol(agControl, role, col),
        };
    },
    ColorCol: (agControl, role, col) => {
        return {
            lockPinned: true,
            filter: false,
            menuTabs: [],
            sortable: false,
            wrapText: false,
            cellRenderer: ColorCol(agControl, role, col),
        };
    },
    ReviewCol: (agControl, role, col) => {
        return {
            lockPinned: true,
            filter: false,
            menuTabs: [],
            sortable: false,
            valueFormatter: (params) => {
                return "●";
            },
            cellStyle: (params) => {
                return {
                    color: params.value ? "rgb(10 187 40)" : "rgb(187 187 187)",
                    "text-align": "center",
                    padding: "0",
                };
            },
        };
    },
};
