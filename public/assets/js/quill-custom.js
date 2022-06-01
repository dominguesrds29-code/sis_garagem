$(function(){
    var enunciado = new Quill('#enunciado', {
        modules: {
            toolbar: [[{header: [1, 2, false]}], ['bold', 'italic'], ['blockquote', 'image'], [{list: 'ordered'}, {list: 'bullet'}]]
        },
        placeholder: 'Seu texto aqui...',
        theme: 'snow'  // or 'bubble'
    });
    var alter_a = new Quill('#alter_a', {
        modules: {
            toolbar: [[{header: [1, 2, false]}], ['bold', 'italic'], ['blockquote', 'image'], [{list: 'ordered'}, {list: 'bullet'}]]
        },
        placeholder: 'Seu texto aqui...',
        theme: 'snow'  // or 'bubble'
    });
    var alter_b = new Quill('#alter_b', {
        modules: {
            toolbar: [[{header: [1, 2, false]}], ['bold', 'italic'], ['blockquote', 'image'], [{list: 'ordered'}, {list: 'bullet'}]]
        },
        placeholder: 'Seu texto aqui...',
        theme: 'snow'  // or 'bubble'
    });
    var alter_c = new Quill('#alter_c', {
        modules: {
            toolbar: [[{header: [1, 2, false]}], ['bold', 'italic'], ['blockquote', 'image'], [{list: 'ordered'}, {list: 'bullet'}]]
        },
        placeholder: 'Seu texto aqui...',
        theme: 'snow'  // or 'bubble'
    });
    var alter_d = new Quill('#alter_d', {
        modules: {
            toolbar: [[{header: [1, 2, false]}], ['bold', 'italic'], ['blockquote', 'image'], [{list: 'ordered'}, {list: 'bullet'}]]
        },
        placeholder: 'Seu texto aqui...',
        theme: 'snow'  // or 'bubble'
    });
    var alter_e = new Quill('#alter_e', {
        modules: {
            toolbar: [[{header: [1, 2, false]}], ['bold', 'italic'], ['blockquote', 'image'], [{list: 'ordered'}, {list: 'bullet'}]]
        },
        placeholder: 'Seu texto aqui...',
        theme: 'snow'  // or 'bubble'
    });
    var resolucao = new Quill('#resolucao', {
        modules: {
            toolbar: [[{header: [1, 2, false]}], ['bold', 'italic'], ['blockquote', 'image'], [{list: 'ordered'}, {list: 'bullet'}]]
        },
        placeholder: 'Seu texto aqui...',
        theme: 'snow'  // or 'bubble'
    });

    $('#formQuestao').on('submit', function(e){
        if(enunciado.getText().trim().length !== 0) $('textarea[name="enunciado"]').val($('#enunciado .ql-editor').html());
        if(alter_a.getText().trim().length !== 0) $('textarea[name="alter_a"]').val($('#alter_a .ql-editor').html());
        if(alter_b.getText().trim().length !== 0) $('textarea[name="alter_b"]').val($('#alter_b .ql-editor').html());
        if(alter_c.getText().trim().length !== 0) $('textarea[name="alter_c"]').val($('#alter_c .ql-editor').html());
        if(alter_d.getText().trim().length !== 0) $('textarea[name="alter_d"]').val($('#alter_d .ql-editor').html());
        if(alter_e.getText().trim().length !== 0) $('textarea[name="alter_e"]').val($('#alter_e .ql-editor').html());
        if(resolucao.getText().trim().length !== 0) $('textarea[name="resolucao"]').val($('#resolucao .ql-editor').html());
    });
});
