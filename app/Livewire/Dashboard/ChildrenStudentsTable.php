<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ChildrenUniversity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;


class ChildrenStudentsTable extends Component
{
    use WithPagination;

    public $search = '';
    public $confirmationCode = '';
    public $showPassword = [];
    public $dynamicFields = [];
    public $studentToDeleteId = null;

    protected $queryString = ['search'];

    public function mount()
    {
        $this->dynamicFields = ChildrenUniversity::pluck('meta')
            ->filter()
            ->flatMap(fn($meta) => array_keys((array) $meta))
            ->unique()
            ->values()
            ->all();
    }



    public function getStudentsProperty()
    {
        return ChildrenUniversity::with('user')
            ->when($this->search, function ($query) {
                $query->whereHas(
                    'user',
                    fn($q) =>
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%")
                );
            })
            ->paginate(10);
    }

    public function deleteAll()
    {
        try {
            if ($this->confirmationCode !== '#CH5589') {
                $this->addError('confirmationCode', 'الرمز غير صحيح');
                return;
            }

            $currentUserId = Auth::id();
            $students = ChildrenUniversity::with('user')->get();

            foreach ($students as $student) {
                if ($student->user && $student->user->id !== $currentUserId) {
                    DB::transaction(function () use ($student) {
                        $student->user->delete();
                        $student->delete();
                    });
                }
            }

            $this->dispatch('alert', 'تم حذف جميع الطلاب بنجاح!');
            $this->reset('confirmationCode');
        } catch (\Exception $e) {
            $this->dispatch('alert', 'فشل الحذف الجماعي: ' . $e->getMessage());
        }
    }

    public function deleteStudent($id)
    {
        try {
            $student = ChildrenUniversity::with('user')->findOrFail($id);

            if ($student->user && $student->user->id === Auth::id()) {
                $this->dispatch('alert', 'لا يمكنك حذف حسابك الخاص!');
                return;
            }

            DB::transaction(function () use ($student) {
                if ($student->user) {
                    $student->user->delete();
                }
                $student->delete();
            });

            $this->dispatch('alert', 'تم الحذف بنجاح!');
            $this->reset('studentToDeleteId');
        } catch (\Exception $e) {
            $this->dispatch('alert', 'فشل الحذف: ' . $e->getMessage());
        }
    }

    public function togglePassword($userId)
    {
        try {
            $user = ChildrenUniversity::findOrFail($userId);
            $password = decrypt($user->password);
            $this->showPassword[$userId] = $password;
        } catch (\Exception $e) {
            $this->showPassword[$userId] = 'Error';
        }
    }

    public function hidePassword($userId)
    {
        $this->showPassword[$userId] = null;
    }

    public function render()
    {
        return view('livewire.dashboard.children-students-table', [
            'students' => $this->getStudentsProperty(),
            'dynamicFields' => $this->dynamicFields,
        ]);
    }
}
