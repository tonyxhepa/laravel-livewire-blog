<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Posts extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $modalFormVisible = false;
    public $modelId;
    public $title;
    public $body;
    public $image = null;
    public $newImage;

    protected $rules = [
        'title' => 'required|min:6',
        'body' => 'required|min:6',
        'newImage' => 'required:image|max:1024'
    ];

    public function deletePost($id)
    {
        $post = Post::findOrFail($id);
        Storage::delete('public/photos/'. $post->image);
        $post->delete();
    }

    public function createShowModal()
    {
        $this->resetValidation();
        $this->reset();
        $this->modalFormVisible = true;
    }

    public function loadPost()
    {
        $post = Post::find($this->modelId);
        $this->title = $post->title;
        $this->body = $post->body;
        $this->image = $post->image;
    }

    public function update()
    {
        $this->validate([
        'title' => 'required|min:6',
        'body' => 'required|min:6',
        'newImage' => 'image|max:1024|nullable'
        ]);

        if ($this->newImage) {
            Storage::delete('public/photos/'. $this->image);

            $this->image = $this->newImage->getClientOriginalName().'-'. Carbon::now();

            $this->newImage->storeAs('public/photos/', $this->image);
        }

        Post::find($this->modelId)->update([
             'title' => $this->title,
             'body' => $this->body,
              'image' => $this->image
        ]);
        $this->modalFormVisible = false;

        // $this->dispatchBrowserEvent('event-notification', [
        //     'eventName' => 'Updated Page',
        //     'eventMessage' => 'There is a page (' . $this->modelId . ') that has been updated!',
        // ]);
    }

    public function savePost()
    {
        $this->validate();
        $image_name = $this->newImage->getClientOriginalName().'-'. Carbon::now();

        $this->newImage->storeAs('public/photos/', $image_name);
        $post = new Post();
        $post->user_id = auth()->user()->id;
        $post->title = $this->title;
        $post->body = $this->body;
        $post->slug = Str::slug($this->title);
        $post->image = $image_name;
        $post->save();
        $this->modalFormVisible = false;

        $this->clearForm();
    }

    public function clearForm()
    {
        $this->title = '';
        $this->body = '';
        $this->image = '';
    }

    public function updateShowModal($id)
    {
        $this->resetValidation();
        $this->reset();
        $this->modelId = $id;
        $this->modalFormVisible = true;
        $this->loadPost();
    }

    public function render()
    {
        return view('livewire.posts', [
            'posts' => Post::paginate(3)
        ])->layout('layouts.app');
    }
}
