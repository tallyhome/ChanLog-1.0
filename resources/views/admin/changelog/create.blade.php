@extends('layouts.admin')

@section('title', 'Nouvelle Version')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1>Créer une Nouvelle Version</h1>
            
            <form action="{{ route('admin.changelog.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="version_number" class="form-label">Numéro de version</label>
                    <input type="text" class="form-control" id="version_number" name="version_number" required>
                </div>
                
                <div class="mb-3">
                    <label for="release_date" class="form-label">Date de sortie</label>
                    <input type="date" class="form-control" id="release_date" name="release_date" required>
                </div>
                
                <!-- Le champ description a été supprimé -->
                
                <div class="mb-3">
                    <label for="content" class="form-label">Changements</label>
                    <textarea class="form-control" id="content" name="content" rows="10" required></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </form>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Versions existantes</h5>
                </div>
                <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                    <ul class="list-group">
                        @foreach($versions as $existingVersion)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>v{{ $existingVersion->version_number }}</strong>
                                        <br>
                                        <small>{{ $existingVersion->release_date->format('d/m/Y') }}</small>
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.changelog.edit', $existingVersion->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/lang/summernote-fr-FR.min.js"></script>
<script>
    $(document).ready(function() {
        $('#content').summernote({
            placeholder: 'Entrez le contenu de la version ici...',
            height: 300,
            lang: 'fr-FR',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                onImageUpload: function(files) {
                    for (let i = 0; i < files.length; i++) {
                        let formData = new FormData();
                        formData.append('file', files[i]);
                        $.ajax({
                            url: '{{ route("admin.upload.image") }}',
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                                $('#content').summernote('insertImage', data.location);
                            },
                            error: function(xhr) {
                                console.error('Erreur lors de l\'upload:', xhr.responseText);
                                alert('Erreur lors de l\'upload de l\'image');
                            }
                        });
                    }
                }
            }
        });
    });
</script>
@endpush