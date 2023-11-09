<!DOCTYPE html>
<html lang="ru">
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <title>NoteBook</title>
</head>

<body>

<header>
    <button id="addNoteBtn">Создать заметку</button>
</header>
<div id="notes-container">

    @if($notes)
        @foreach($notes as $note)
            <div class='note'>
                <div class='note-title'>
                    <span>{{$note->title}}</span>
                </div>
                <div class='note-content'>
                    <span>{{$note->note}}</span>
                </div>
                <div class="buttons">
                    <button onclick="updateNote({{$note->id}})" id="editButton">Изменить</button>
                    <button onclick="deleteNote({{$note->id}})" id="deleteButton">Удалить</button>
                </div>
            </div>
        @endforeach
    @else
        <h1>Ещё нет заметок</h1>
    @endif

</div>

<div id="note-modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form action="/notebook/add" method="post">
            @csrf
            <input name="title" type="text" id="note-title" placeholder="Заголовок" required>
            <textarea name="note" id="note-content" placeholder="Заметка" required></textarea>
            <button type="submit" onclick="addNote()" id="saveNote">Сохранить</button>
            <button type="button" id="cancelNote" class="cancelNote">Отменить</button>
        </form>
    </div>
</div>

@foreach($notes as $note)
    <div id="update-note-modal-{{$note->id}}" class="modal">
        <div class="modal-content">
            <span id="close-{{$note->id}}" class="close">&times;</span>
            <form action="/notebook/update/{{$note->id}}" method="post">
                @csrf
                @method('PUT')
                <input name="title" class="update-note-title" type="text" id="update-note-title-{{$note->id}}" placeholder="Заголовок" required>
                <textarea name="note" class="update-note-content" id="update-note-content-{{$note->id}}" placeholder="Заметка" required></textarea>
                <button type="submit" class="saveUpdatedNote" id="saveNote">Сохранить</button>
                <button type="button"  class="cancelNote" id="updateCancelNote-{{$note->id}}">Отменить</button>
            </form>
        </div>
    </div>
@endforeach

<script>
    const addNoteBtn = document.getElementById("addNoteBtn");
    const notesContainer = document.getElementById("notes-container");
    const noteModal = document.getElementById("note-modal");
    const closeBtn = document.querySelector(".close");
    const noteTitle = document.getElementById("note-title");
    const noteContent = document.getElementById("note-content");
    const saveNoteBtn = document.getElementById("saveNote");
    const cancelNoteBtn = document.getElementById("cancelNote");

    addNoteBtn.addEventListener('click', function () {
        noteModal.style.display = 'block';
    });

    closeBtn.addEventListener('click', function () {
        noteModal.style.display = 'none';
    });

    cancelNoteBtn.addEventListener('click', function () {
        noteModal.style.display = 'none';
    });

    function addNote()
    {
        $.ajax({
            type: 'POST',
            url: '/notebook/add/',
            headers: {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },

            success: function (response) {
                return response.responseText;
            },
            error: function (response) {
                console.log(response.responseText);
            }
        });
    }

    function deleteNote(id)
    {
        $.ajax({
            type: 'DELETE',
            url: '/notebook/delete/' + id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                window.location.reload();
            },
            error: function (response) {
                console.log(response.responseText);
            }
        });
    }

    function updateNote(id)
    {
        const updateCancelButton = document.getElementById('updateCancelNote-' + id);
        const modal = document.getElementById('update-note-modal-' + id);
        const closeButton = document.getElementById('close-' + id);

        closeButton.addEventListener('click', function () {
            modal.style.display = 'none';
        });

        updateCancelButton.addEventListener('click', function () {
            modal.style.display = 'none';
        });

        $.ajax({
            type: 'GET',
            url: '/notebook/get/' + id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function (response) {
                console.log(response.title);
                $('#update-note-title-' + id).val(response.title);
                $('#update-note-content-' + id).val(response.note);
                modal.style.display = 'block';
            },

            error: function (response) {
                console.log(response.responseText);
            }
        });
    }
</script>

</body>
</html>
