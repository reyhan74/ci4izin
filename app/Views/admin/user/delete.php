public function delete($id)
{
$this->user->delete($id);
return redirect()->to('admin/users');
}