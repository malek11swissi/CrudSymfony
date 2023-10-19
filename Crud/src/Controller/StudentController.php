<?php

namespace App\Controller;
use App\Entity\Student;
use App\Entity\Classroom;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use App\Repository\ClassroomRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

//#[Route('/student', name: 'student')]

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

    #[Route('/fetch', name: 'fetch')]
    public function fetch(StudentRepository $repo): Response
    {  $result=$repo->findAll();
        return $this->render('student/test.html.twig', [
            'response' => $result,
        ]);
    }

    #[Route('/ajout',name:'ajout')]
    public function ajout(ManagerRegistry $mr,ClassroomRepository $rep,Request $req):Response
    {           $form=$this->createForm(StudentType::class,$s);
    }



    #[Route('/add',name:'add')]
    public function add(ManagerRegistry $mr,ClassroomRepository $rep,Request $req):Response
    {   
        $s=new Student();//1 instance    update 
        $form=$this->createForm(StudentType::class,$s);
        $form->add('save_me',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted()){
        $em=$mr->getManager();//3 persist+flush
        $em->persist($s);
        $em->flush();
        return $this->redirectToRoute('fetch');   
    }       

        return $this->render('student/addstudent.html.twig',[
            'f'=>$form->createView() //update ttbadel
        ]);
       
    }

    #[Route('/delete/{id}', name: 'delete_student')]
    public function delete(Student $student, ManagerRegistry $mr): Response
    {
        $em = $mr->getManager();
        $em->remove($student);
        $em->flush();

        return $this->redirectToRoute('fetch');
    }


    #[Route('/modifier/{id}', name: 'modifier_student')]
public function update(int $id, Request $request, EntityManagerInterface $em): Response
{
    $student = $em->getRepository(Student::class)->find($id);

    if (!$student) {
        throw $this->createNotFoundException('Étudiant non trouvé pour l\'ID ' . $id);
    }

    $form = $this->createForm(StudentType::class, $student);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->flush();

        return $this->redirectToRoute('fetch');
    }

    return $this->render('student/updatestudent.html.twig', [
        'f' => $form->createView(),
    ]);
}




    /*#[Route('/update/{id}',name:'update')]
    public function update(ManagerRegistry $mr, int $id):Response
    { $s=$mr->getRepository(Student::class)->find($id);
        $em=$mr->getManager();

        if(!$s)
       { throw $this->createNotFoundException('No Student found for id '.$id );}
    $s->setNom('New ');
    $em->flush();
    return $this->redirectToRoute('fetch');}
*/
    /*#[Route('/delete/{id}',name:'delete')]
    public function remove(ManagerRegistry $mr, int $id):Response
    { $s=$mr->getRepository(Student::class)->find($id);
        $em=$mr->getManager();

        if(!$s)
       { throw $this->createNotFoundException('No Student found for id '.$id );}
        //return new Response ("Etudiant introuvable");
            $em->remove($s);
    $em->flush();
    return $this->redirectToRoute('fetch');}
      */   
    }

