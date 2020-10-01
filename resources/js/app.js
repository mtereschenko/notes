/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import $ from 'jquery';
import Swal from 'sweetalert2'

import 'summernote/dist/summernote-bs4';
import 'summernote/dist/summernote-bs4.css';

$(".summernote").summernote({
    minHeight: 150,
    disableDragAndDrop: true
});

$('.toggle_publish').click(function () {
    let url = $(this).data('url');
    Swal.fire({
        title: '',
        text: "Змінити статус приватності?",
        icon: 'question',
        iconHtm: '?',
        showCancelButton: true,
        confirmButtonColor: '#727272',
        cancelButtonColor: '#252525',
        confirmButtonText: 'Змінити',
        cancelButtonText: 'Залишити як є'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                type: 'POST',
                success: function (data) {
                    location.reload();
                }
            });
        }
    })
});

$('.share_note').click(function () {
    let url = $(this).data('url');
    Swal.fire({
        title: 'Кому відправимо записку?',
        input: 'email',
        showCancelButton: true,
        confirmButtonText: 'Поділитися',
        confirmButtonColor: '#727272',
        cancelButtonColor: '#252525',
        showLoaderOnConfirm: true,
        preConfirm: (email) => {
            return new Promise(resolve => {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {email},
                    success: function (data) {
                        resolve();
                    }
                });
            })
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Записка надіслана. Дякую за те що поділились ;)',
                confirmButtonColor: '#727272',
            })
        }
    })
});

$('.need_to_fade').click(function (e) {
    let href = $(this).attr('href');
    e.preventDefault();
    $('main').fadeTo(100, 0.00, function () {
        window.location.href = href;
    });
});

$(document).ready(function () {
    $('main').fadeTo(100, 1);
});

$('.header_link').click(function () {
    let href = $(this).find("a").attr('href');
    $('main').fadeTo(100, 0.00, function () {
        window.location.href = href;
    });
});