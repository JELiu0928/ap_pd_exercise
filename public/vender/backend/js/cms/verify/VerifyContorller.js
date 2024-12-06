import { verifySet } from './verifySet.js';
import { editState } from '../states/editState.js';

export default class VerifyController {

    #inputs = [];
    #scrolling = false;

    /** @param {JQuery<HTMLElement>} editArea */
    constructor(editArea) {
        this.editArea = editArea;
    }



    /** @param {JQuery<HTMLElement} inputs */
    addInputs(inputs) {
        const controller = this;
        $('#errorMeg').each(function () {
            const self = this;
            // self.removeAttribute('id');

            $(this).addClass('errorMeg').on('mousedown', controller.#moveEvent(self));
            $(this).find('.errorMeg_header span').on('click',function(){
                $(self).removeClass('active');
            });
        })

        this.#inputs = [...this.#inputs, ...inputs.get().map((el) => {
            return this.#inputModel(el);
        })];
    }

    #moveEvent(element) {
        const el = $(element);
        let moving = false;
        let cssX = 0;
        let cssY = 0;

        return (e) => {
            let curX = e.screenX;
            let curY = e.screenY;
            $(document).on('mousemove', mouseMove)
            $(document).on('mouseup', () => $(document).off('mousemove', mouseMove));

            function mouseMove(e) {
                if (moving) return;
                moving = true;
                const x = e.screenX;
                const y = e.screenY;
                cssX = cssX + x - curX;
                cssY = cssY + y - curY
                el.css('transform', `translateX(${cssX}px) translateY(${cssY}px)`);
                curX = x;
                curY = y;
                setTimeout(() => {
                    moving = false;
                }, 20)
            }
        }
    }

    /** @param {HTMLElement} element */
    #inputModel(element) {
        const verifyControl = this;
        const el = $(element);
        const options = JSON.parse(el.attr('data-verify'));
        const roles = Object.keys(options);
        const field = $(element).closest('li.inventory').find('.subtitle').eq(0).text()?.trim() ?? '';

        let message = '';
        const model = {
            element,
            set message(val) {
                if (val === '') {
                    el.closest('.inventory').removeAttr('style');
                } else {
                    el.closest('.inventory')
                        .css('background-color', 'palegoldenrod')
                        .css('border-radius', '3px');
                }
                message = val;
            },
            get message() {
                return message;
            },
            verify() {
                let result = true;
                if (el.parents('form:not([id])')?.find(' > .wait-save-box')?.find('input')?.get()
                    .reduce((res, input) => res || $(input).val() == '1', false)) {
                    return result;
                }

                for (const role of roles) {
                    if (verifySet[role]) {
                        result = verifySet[role].check(el.val()?.trim(), options, verifyControl.editArea);
                        if (result) {
                            model.message = '';
                        } else {
                            model.message = verifySet[role].meg(field, options, verifyControl.editArea);
                            break;
                        };
                    }
                }
                return result;
            },
            exist() {
                return el.parents('form').length > 0;
            }
        }

        element.addEventListener('change', async function () {
            editState.changing = true;
            if (!model.verify()) {
                await verifyControl.#scrollToInput(model);
                alert(model.message);
            };
            editState.changing = false;
        });

        ('clear' in options) && this.#addInputEvent(model, options);

        el.removeAttr('data-verify');

        return model;
    }

    #addInputEvent(model, options) {
        const chars = Array.from(options.clear);
        if (chars.length === 0) return;

        const regex = new RegExp(`(${chars.join('|')})+`);
        model.element.addEventListener('input', function () {
            const self = this;
            const match = self.value.match(regex)?.[0];
            if (!match || match.length === 0) return;
            const caretPosition = self.selectionStart - match.length;
            const newVal = self.value.replace(regex, '');
            $(self).val(newVal).attr('value', newVal);
            self.setSelectionRange(caretPosition, caretPosition);
        })

    }

    saveVerify() {
        return new Promise(async res => {
            editState.changing = true;
            let models = [];
            for (const model of this.#inputs) {
                if (!model.verify()) {
                    models.push(model);
                }
                //日期區間例外判斷必填
                const isDateRange = $(model.element).closest('.datepicker-range').length > 0 ? true : false;
                if(isDateRange){
                    let _DateRange = $(model.element).closest('.datepicker-range').find('input');
                    if($(_DateRange[0]).val() != '' && $(_DateRange[1]).val() == ''){
                        let element = $(_DateRange[1]);
                        let message = element.closest('li.inventory').find('.subtitle').eq(0).text()?.trim();
                        element.closest('.inventory').css('background-color', 'palegoldenrod').css('border-radius', '3px');
                        console.log(element);
                        const _DateRangemodel = {
                            element,
                            get message() {
                                return message + '為必填欄位';
                            }
                        }
                        models.push(_DateRangemodel);
                    }
                }
            }
            this.#setMessageBox(models);
            editState.changing = false;
            setTimeout(() => {
                res(models.length === 0);
            }, 200);
        })
    }

    #setMessageBox(models) {
        const el = $('#errorMeg');
        el.find('.errorMeg_list').html('');
        if (models.length === 0) {
            return;
        }

        for (const model of models) {
            const div = document.createElement('div');
            div.style.cursor = 'pointer';
            div.addEventListener('click', () => {
                el.find('.errorMeg_list div').removeClass('active');
                div.classList.add('active');
                this.#scrollToInput(model);
            });
            div.innerText = model.message;
            el.find('.errorMeg_list').append(div);
        }

        el.addClass('active');

    }

    #scrollToInput(model) {
        if (this.#scrolling) return;
        this.#scrolling = true;
        return new Promise(res => {
            const el = $(model.element);
            const formKey = el.closest('form[id]').attr('id');
            this.editArea.find(`li[data-form="${formKey}"]`).get(0).click();

            const id = el.closest('.part_content').attr('body-id');

            const scroll = el.closest('.scroll-content');
            if (scroll.length > 0) {
                scroll.animate({
                    scrollTop: el.parents('form:not([id])').get().reduce((res, e) => {
                        let form = $(e).addClass('active');
                        form.find(' > .list_frame').addClass('open').slideDown();
                        return res + form.position().top
                    }, 0) +
                        el.closest('li.inventory').position().top -
                        window.innerHeight / 4,
                }, 500, null, () => {
                    res('');
                    this.#scrolling = false;
                });
            }

        })
    }

    existFilter() {
        this.#inputs = this.#inputs.filter((model) => {
            return model.exist();
        })
    }

    clearInputs() {
        this.#inputs = [];
    }

}
