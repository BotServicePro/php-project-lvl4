@extends('layouts.app')

@section('title', 'Main page')

@section('content')
    <main class="container py-4">
        <h1>Main page</h1>
        @if (Auth::check())
            {{ Auth::user()->name }}
        @endif
        <br>
        <h4><b>Тестовые данные:</b> login - alex@mail.ru, password - test</h4>


        Добавить тесты на фильтр<br>
        Разобраться с тестовыми данными в тестах, возможно создать фабрику<br>
        Разобраться с предварительно выбранными вариантами select2 в CRUD допустим в edit<br>

        Реализуйте фильтрацию, которая работает аналогично примеру Хекслета. Используйте для этого готовую библиотеку laravel-query-builder - ГОТОВО<br>
        РАЗОБРАТЬСЯ С ПАГИНАЦИЕЙ!!! - ГОТОВО<br>
        Напишите нужные тесты - ГОТОВО<br>
        Реализуйте CRUD меток. Если метка используется в задаче, то она не должна удаляться. Вместо этого выводится флеш сообщение: "Не удалось удалить метку" - ГОТОВО<br>
        Реализуйте форму добавления и редактирования метки на отдельных страницах: labels/create и labels/{id}/edit, соответственно - ГОТОВО<br>
        Имя поля ввода input должно быть name - ГОТОВО<br>
        Реализуйте вывод всех добавленных меток на отдельной странице labels - ГОТОВО<br>
        Сделайте возможность добавления меток в задачи при их создании и изменении - ГОТОВО<br>
        Реализуйте вывод меток, которые привязаны к задаче на странице tasks/{id} - ГОТОВО<br><br>


        Разобраться с авторизацией на маршрутах - ГОТОВО - создана политика с соответсвующими правами - ГОТОВО<br>
        Написать тесты на CRUD статусов - ГОТОВО<br>
        Добавить флэш сообщения - ГОТОВО<br>
        Добавить флэш сообщения в lang файлы - ГОТОВО<br>
        Добавить Сидеры - ГОТОВО<br>
        ДОБАВИТЬ CRUD статусов - ГОТОВО<br><br>

        Разрешить удаление только тех статусов, которе не привязаны ни к одной задаче! (Чужие статусы тоже можно удалять) - ГОТОВО<br>
        Доработайте обработчик удаления статусов. Если статус используется в задаче, то он не должен удаляться. Вместо этого выводится флеш сообщение: "Не удалось удалить статус" - ГОТОВО<br>
        Написать тесты на контроллер задач - ГОТОВО<br>
        Реализуйте CRUD задач - ГОТОВО<br>
        Реализуйте форму добавления и редактирования задачи на отдельных страницах: tasks/create и tasks/{id}/edit, соответственно - ГОТОВО<br>
        Имена полей формы должны быть следующими: name, description, status_id и assigned_to_id - ГОТОВО<br>
        Реализуйте вывод всех добавленных задач на отдельной странице tasks - ГОТОВО<br>
        Реализуйте вывод конкретной задачи на отдельной странице tasks/{id} - ГОТОВО<br>
        Подключите флеш сообщения. Храните все тексты интерфейсов в i18n - ГОТОВО<br>
        Добавьте ссылку на список задач в основное меню - ГОТОВО<br>
        Сделайте так, чтобы добавлять, редактировать задачи могли бы только залогиненные пользователи. Удалять задачи может только создатель - ГОТОВО<br>
        Напишите тесты на контроллер задач если вы еще этого не сделали - ГОТОВО<br>
    </main>
@endsection
