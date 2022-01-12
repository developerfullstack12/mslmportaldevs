/**
 * @file elc-h5p-ld.js
 * Created by michaeldajewski on 7/04/19.
 */

var H5P = H5P || {};

var elcH5PLdQuizGlobalPointsDelta = 0;
var elcQuizPassingPercentage = 0;

(function ($) {
    'use strict';

    var elcClearH5PUserDataAJAX = function (elcAJAX, h5pIDs) {
        $.ajax({
            url: elcAJAX.url,
            type: 'post',
            data: {
                action: 'elc_clear_h5p_user_data',
                nonce: elcAJAX.nonce,
                h5pIDs: JSON.stringify(h5pIDs)
            },
            success: function (response) {

            },
            error: function () {
                var errorMessage = 'response undefined ';
            }
        });
    };

    var elcSendAJAX = function (elcAJAX, xapi) {
        $.ajax({
            url: elcAJAX.url,
            type: 'post',
            data: {
                action: 'elc_insert_data',
                nonce: elcAJAX.nonce,
                xapi: JSON.stringify(xapi)
            },
            success: function (response) {
                if (response) {
                    if (response.data) {
                        var data = response.data;
                        if (parseInt(elcAJAX.elc_debug)) console.log(data);

                        var learndash_mark_complete_button = $('.learndash_mark_complete_button');
                        if (learndash_mark_complete_button.length) {
                            learndash_mark_complete_button.prop('disabled', !data.ldMarkCompleteButtonEnable);
                        }

                        var startQuiz = $('.wpProQuiz_button[name=startQuiz]');
                        if (startQuiz.length) {
                            startQuiz.prop('disabled', !data.wpProQuizButtonEnable);
                        }

                        var elcH5PResponse = $('.elc-h5p-response.h5pid-' + data.h5pId);
                        if (elcH5PResponse.length) {
                            var classList = elcH5PResponse.attr('class').split(/\s+/);
                            // Compare elcH5PResponse.selector with classList
                            // If class in the classList is not in selector,
                            // replace it with data.elcH5Presponse.cssClass.
                            $.each(classList, function (key, className) {
                                if (!elcH5PResponse[0].classList.contains(className)) {
                                    // Replace value with data.elcH5Presponse.cssClass
                                    elcH5PResponse.removeClass(className).addClass(data.elcH5Presponse.cssClass);
                                    return false;
                                }
                            });
                            elcH5PResponse[0].innerHTML = data.elcH5Presponse.text;
                        }

                        // If this is a quiz page than find the H5P iframe, its closesest 'wpProQuiz_listItem'
                        // 'elcQuizPassingPercentage' and 'elcQuizGPdelta' are declared in callback elc_insert_data()
                        // only when the post type is 'sfwd-quiz' and answer type is 'assessment_answer'.
                        if (data.elcQuizPassingPercentage !== null) {
                            var wpProQuiz_question = $('.h5p-initialized[data-content-id=' + data.h5pId + ']').closest(".wpProQuiz_question");
                            var wpProQuiz_questionList = wpProQuiz_question.find('.wpProQuiz_questionList');
                            let wpProQuiz_questionList_class = '';
                            if(elcAJAX.question_label == 'hide') {
                                wpProQuiz_questionList_class = ' elc_h5p_hide';
                            }
                            if (data.questionUpdated !== null) {
                                // Insert Html element into the 'wpProQuiz_questionListItem'
                                let wpProQuiz_content = wpProQuiz_question.closest('.wpProQuiz_content');
                                let data_quiz_meta_json = wpProQuiz_content.attr('data-quiz-meta'); // JSON string
                                let quiz_pro_id = $.parseJSON(data_quiz_meta_json).quiz_pro_id;
                                let data_question_id = wpProQuiz_questionList.attr('data-question_id');
                                let wpProQuiz_questionList_outerHTML = '';
                                wpProQuiz_questionList_outerHTML += '<ul class="wpProQuiz_questionList' + wpProQuiz_questionList_class + '" data-question_id="' + data_question_id + '" data-type="assessment_answer">';
                                wpProQuiz_questionList_outerHTML += '<li class="wpProQuiz_questionListItem" data-pos="0">';
                                wpProQuiz_questionList_outerHTML += '<p>' + data.answerText + ': <label><input type="radio" value="1" name="question_' + quiz_pro_id + '_' + data_question_id + '_0" class="wpProQuiz_questionInput" data-index="0" style="display: none;">0</label></p>';
                                wpProQuiz_questionList_outerHTML += '</li></ul>';
                                wpProQuiz_questionList.prop('outerHTML', wpProQuiz_questionList_outerHTML);
                            }
                            var radioInput = wpProQuiz_question.find("input.wpProQuiz_questionInput").first();
                            radioInput.val(data.score.raw);
                            radioInput.attr("checked", true);
                            radioInput.parent().contents().last()[0].nodeValue = data.score.raw;//.text(data.score.raw);
                            // Trigger 'questionSolved' event in order to be able to move to the next wpProQuiz_question.
                            // @SEE: wp-content/plugins/sfwd-lms/includes/lib/wp-pro-quiz/js/wpProQuiz_front.js:2344
                            var p = wpProQuiz_question.closest('li.wpProQuiz_listItem');
                            var e = p.closest('.wpProQuiz_content');
                            var s = true;
                            e.trigger({type: 'questionSolved', values: {item: p, index: p.index(), solved: s}});
                            elcH5PLdQuizGlobalPointsDelta += data.elcQuizGPdelta;
                            elcQuizPassingPercentage = data.elcQuizPassingPercentage;
                        }
                        // Enable 'Finish Quiz' button.
                        disableFinishQuiz(false);
                    }
                }
            },
            error: function () {
                // Here we can return any errors from
                // action: 'elc_insert_data'
                // passed through response.data
                //
                var errorMessage = 'response undefined ';
                //console.log('elcSendAJAX() error: ' + errorMessage);
            }
        });
    };

    /**
     * Handle xAPI statements.
     * Filter out events before they are processed.
     *
     * @param {Object} event - Event.
     */
    var elcHandleXAPI = function (event) {
        var response = event.data.statement;
        if (typeof(response.result) !== 'undefined') {

            // Filter out events and send AJAX
            var result = response.result;

            // Must check verb, coursePresentation,
            let verb = response.verb.id.substr(31);
            if (result.completion !== undefined || verb === "answered") {
                var b_parent = typeof(response.context.contextActivities.parent) !== 'undefined' ? true : false;
                // Send AJAX, update DB and update UI on response
                if (!b_parent) {
                    // If it is a quiz question get the quiz ID from 'data-question-meta'.
                    let quizContainer = document.activeElement.closest(".wpProQuiz_content");
                    if (quizContainer !== null) {
                        let dataQuizMeta = quizContainer.closest(".wpProQuiz_content").getAttribute("data-quiz-meta");
                        response["dataQuizMeta"] = JSON.parse(dataQuizMeta);
                        // Disable 'Finish Quiz' button, and wait for elcAJAX.
                        disableFinishQuiz(true);
                    }
                    elcSendAJAX(elcAJAX, response);
                    if (parseInt(elcAJAX.elc_debug)) console.log(response);
                }
            }
        }
    };

    var disableFinishQuiz = function (bDisable) {
        var finishQuiz = $("ol.wpProQuiz_list li.wpProQuiz_listItem:last input[name='next']");
        if (finishQuiz.length && finishQuiz.is(":visible")) {
            finishQuiz.prop('disabled', bDisable);
        }
    };

    var fixWpProQuizResults = function () {
        if (elcH5PLdQuizGlobalPointsDelta !== 0) {
            var newResult = $('.wpProQuiz_results .wpProQuiz_points').find('span');
            if (newResult.length === 3) {
                // We have our html structure.
                var total_points = parseInt(newResult[1].innerHTML) + elcH5PLdQuizGlobalPointsDelta;
                newResult[1].innerHTML = total_points;
                var points = newResult[0].innerHTML;
                var percentage = Math.round(points / total_points * 10000) / 100;
                newResult[2].innerHTML = percentage + '%';
                var quiz_continue_link = $('.quiz_continue_link');
                if (quiz_continue_link.length) {
                    if (percentage < elcQuizPassingPercentage) {
                        quiz_continue_link[0].innerHTML = '';
                        quiz_continue_link.hide();
                    }
                }
            }
        }
    };

    var elcH5pClearUserData = function () {
        if (H5PIntegration.contents !== undefined) {
            let h5pIDs = [];
            $.each(H5PIntegration.contents, function (idx) {
                h5pIDs.push(idx.substr(4));
            });
            elcClearH5PUserDataAJAX(elcAJAX, h5pIDs);
        }
    };

    /**
     * Add xAPI event listener
     */
    document.onreadystatechange = function (e) {
        try {
            if (document.readyState == 'complete') {
                if (typeof(H5P.externalDispatcher) !== 'undefined') {
                    // If .wpProQuiz_listItem has iframe.h5p-iframe-wrapper,
                    // hide all .wpProQuiz_listItem .wpProQuiz_questionList
                    $('.wpProQuiz_listItem').each(function (idx) {
                        var h5pIframe_wrappers = $(this).find('.h5p-initialized');
                        if (h5pIframe_wrappers.length) {
                            var questionResponses = $(this).find('.wpProQuiz_response');
                            $.each(questionResponses, function (index, value) {
                                $(this).addClass('elc_h5p_hide');
                            });
                            // Handle only 'assessment_answer' question type.
                            var questionList = $(this).find('.wpProQuiz_questionList');
                            var data_type = questionList.attr('data-type');
                            if (data_type === 'assessment_answer') {
                                // Hide the LearnDash assessment question if user sets label to 'hide'.
                                if(elcAJAX.question_label == 'hide') {
                                    questionList.addClass('elc_h5p_hide');
                                } else {
                                    // Iterate through text nodes in <p>
                                    let nodes = questionList.find('p').contents().filter(function () {
                                        return this.nodeType == 3;
                                    });
                                    if (nodes.length > 0) {
                                        nodes.each(function (idx) {
                                            if (idx === 0) {
                                                // We want the text to be exactly what is elcAJAX.question_label + ': '
                                                if (this.data !== elcAJAX.question_label + ': ') {
                                                    this.data = elcAJAX.question_label + ': ';
                                                }
                                            } else {
                                                $(this).remove();
                                            }
                                        });
                                    } else {
                                        questionList.find('p').prepend(elcAJAX.question_label + ': ');
                                    }

                                    var radios = questionList.find('.wpProQuiz_questionInput');
                                    // The xAPI event returns result.score.raw where the valu may be 0.
                                    // Change the values set by LD to start from 0 not 1.
                                    $.each(radios, function (index, value) {
                                        $(this).parent().contents().last()[0].textContent = '';
                                        $(this).hide();
                                    });
                                }

                            }
                            // We need to disable mouse events for all H5P iframes if this is the
                            // view results page - the input has attribute disabled="disabled"
                            // or wpProQuiz_results is visible
                            var probablyCourseResultsPage = 0;
                            $('.wpProQuiz_button_reShowQuestion').click(function (e) {
                                if ($('.wpProQuiz_questionInput[disabled="disabled"]').length) {
                                    h5pIframe_wrappers.addClass('elc_h5p_disable');
                                }
                            });
                        }
                    });
                    // Fix H5P iframe size for Learndash Quiz Questions.
                    let wpProQuizListItem = document.querySelectorAll('.wpProQuiz_listItem');
                    //var target = $(('.wpProQuiz_listItem'));
                    if (wpProQuizListItem !== null) {
                        let observer = new MutationObserver(function (mutations) {
                            window.dispatchEvent(new Event('resize'));
                        });
                        wpProQuizListItem.forEach(function (t) {
                            observer.observe(t, {
                                attributes: true
                            });
                        });

                        let wpProQuizResults = document.querySelector('.wpProQuiz_results');
                        if (wpProQuizResults !== null) {
                            var observerWpProQuizResults = new MutationObserver(function (mutations) {
                                fixWpProQuizResults();
                            });
                            observerWpProQuizResults.observe(wpProQuizResults, {
                                attributes: true
                            });
                        }
                    }
                    // Click on 'Restart Quiz' or 'Click Here to Continue' buttons.
                    if (H5PIntegration.saveFreq) {
                        $('input[name="restartQuiz"]').click(function () {
                            elcH5pClearUserData();
                        });
                        $('.quiz_continue_link').click(function () {
                            elcH5pClearUserData();
                        });
                    } else {
                    }
                    // Dispatch H5P event.
                    H5P.externalDispatcher.on('xAPI', elcHandleXAPI);
                } else {
                    return;
                }
            }
        } catch (error) {
            console.log(error);
        }
    };

})(jQuery);
