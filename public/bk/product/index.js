import { _detail } from "./detail.js";
import { _consult } from "./consult.js";
// import { _detail} from './detailModule.js';

$(function () {
    _detail.handleDropdownClick();
    _detail.clearFilter();


    _consult.initPage();
    _consult.handleConsultClick();
    _consult.openLightBox();
    _consult.deletePartClick();
});
