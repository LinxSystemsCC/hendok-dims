@extends('layouts.base')

{{-- Set the Title --}}
@section('title', 'Upliftment Uploads')

{{-- Set to show navbar --}}
@php
    $includeMenu = false;
@endphp

@section('page')

    <style>
        .container-fluid {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            margin-top: 50px;
        }

        .file-list {
            width: 30%;
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 8px;
        }

        .preview-pane {
            width: 70%;
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 8px;
            margin-left: 20px;
        }

        .file-list h2, .preview-pane h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .file-list ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .file-list li {
            padding: 10px 0;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .file-list li:hover {
            background-color: #ddd;
        }

        .preview-content .preview-all {
            height: 100%;
            width: 100%;
            text-align: center;
            position: relative;
        }

        .preview-content img, .preview-all img {
            max-width: 100%;
            max-height: 100%;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .preview-content iframe, .preview-all iframe{
            width: 100%;
            height: 80vh;
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .print-button {
            position: absolute;
            top: 10px;
            right: 30px;
            padding: 8px 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .print-button:hover {
            background-color: #0056b3;
        }
    </style>

    <div class="container-fluid">
        <div class="file-list">
            <h2>File List</h2>
            <ul>
                @foreach ($files as $file)
                    <li data-src="{{ url($file) }}">{{ basename($file) }}</li>
                @endforeach
                
                <button class="btn btn-primary print-all-button">Print All</button>
            </ul>
        </div>
        <div class="preview-pane">
            <h2>Preview</h2>
            <div class="preview-content"></div>
            <div class="preview-all" hidden></div>
        </div>
    </div>

@endsection

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.8.335/pdf.min.js"></script>

<script>
    
    $(document).ready(function() {

        // Handle file click
        $('.file-list li').click(function() {
            var src = $(this).data('src');
            $('.preview-content').empty(); // Clear previous content
            if (src.endsWith('.pdf')) {
                // If PDF, embed using iframe
                $('.preview-content').html('<iframe src="' + src + '" frameborder="0"></iframe>');
            } else {
                // If image, display using img tag
                $('.preview-content').html('<img src="' + src + '" alt="Preview">');
                $('.preview-content').append('<button class="print-button">Print</button>');
            }
        });

        $(document).on('click', '.print-all-button', function() {
            var previewAll = $('.preview-all');
            previewAll.empty();
            $('.file-list li').each(function() {
                var src = $(this).data('src');
                var fileType = src.substring(src.lastIndexOf('.') + 1).toLowerCase();
                if (fileType === 'pdf') {
                    // previewAll.append('<iframe src="' + src + '" frameborder="0"></iframe>');
                } else {
                    previewAll.append('<img src="' + src + '" alt="Preview">');
                }
            });
            // previewAll.show();

            var content = $('.preview-all').html();
            
            setTimeout(function() {
                document.body.innerHTML = content;
                window.print();
                location.reload();
            }, 1000);
            
            
        });

        // Print button functionality
        $(document).on('click', '.print-button', function() {
            $(this).prop('hidden', true);
            var content = $('.preview-content').html();
            document.body.innerHTML = content;
            window.print();
            location.reload();
        });

    });
</script>

@endsection



