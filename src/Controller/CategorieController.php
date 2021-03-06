<?php


namespace App\Controller;


use App\Entity\Categorie;
use App\Form\CategorieFormType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class CategorieController extends BaseController
{

    private $categorieRepository;
        private $entityManager;

    public function __construct(CategorieRepository $categorieRepository,EntityManagerInterface $entityManager)
    {
        $this->categorieRepository = $categorieRepository;
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/admin/categorie",name="app_admin_categories")
     * @IsGranted("ROLE_MANAGER")
     */
    public function users(){
        $categories = $this->categorieRepository->findAll();
        return $this->render("admin/categorie/categorie.html.twig",["categories"=>$categories]);
    }

    /**
     * @Route("/admin/categorie/new",name="app_admin_new_categorie")
     * @IsGranted("ROLE_MANAGER")
     * @param Request $request
     * @param TranslatorInterface $translator
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newCategorie(Request $request, TranslatorInterface $translator){
        $form = $this->createForm(CategorieFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            /** @var  Categorie $categorie */
            $categorie = $form->getData();
            $categorie->setValid(true)
                ->setDeleted(false);
            $this->entityManager->persist($categorie);
            $this->entityManager->flush();
            $this->addFlash("success", $translator->trans('backend.category.add_category'));
            return $this->redirectToRoute("app_admin_categories");

        }
        return $this->render("admin/categorie/categorieform.html.twig",["categorieForm"=>$form->createView()]);
    }

    /**
     * @Route("/admin/categorie/edit/{id}",name="app_admin_edit_categorie")
     * @IsGranted("ROLE_MANAGER")
     */
    public function editCategorie(Categorie $categorie,Request $request, TranslatorInterface $translator){
        $form = $this->createForm(CategorieFormType::class,$categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $categorie->setValid(true)
                ->setDeleted(false);
            $this->entityManager->persist($categorie);
            $this->entityManager->flush();
            $this->addFlash("success", $translator->trans('backend.category.edited_category'));
            return $this->redirectToRoute("app_admin_categories");
        }
        return $this->render("admin/categorie/categorieform.html.twig",["categorieForm"=>$form->createView()]);
    }

    /**
     * @Route("/admin/categorie/changevalidite/{id}",name="app_admin_changevalidite_categorie",methods={"post"})
     * @IsGranted("ROLE_MANAGER")
     */
    public function activate(Categorie $categorie){
        $categorie = $this->categorieRepository->changeValidite($categorie);
        return $this->json(["message"=>"success","value"=>$categorie->getValid()]);
    }

    /**
     * @Route("/admin/categorie/delete/{id}",name="app_admin_delete_categorie")
     * @IsGranted("ROLE_MANAGER")
     */
    public function delete(Categorie $categorie){
        $categorie = $this->categorieRepository->delete($categorie);
        return $this->json(["message"=>"success","value"=>$categorie->getDeleted()]);
    }

    /**
     * @Route("/admin/categorie/groupaction",name="app_admin_groupaction_categorie")
     * @IsGranted("ROLE_MANAGER")
     */
    public function groupAction(Request $request){
        $action = $request->get("action");
        $ids = $request->get("ids");
        $categories = $this->categorieRepository->findBy(["id"=>$ids]);
        if ($action=="deactivate" && $this->isGranted("ROLE_MANAGER")){
            foreach ($categories as $categorie) {
                $categorie->setValid(false);
                $this->entityManager->persist($categorie);
            }
        }else if ($action=="activate" && $this->isGranted("ROLE_MANAGER")){
            foreach ($categories as $categorie) {
                $categorie->setValid(true);
                $this->entityManager->persist($categorie);
            }
        }else if ($action=="delete" && $this->isGranted("ROLE_MANAGER")){
            foreach ($categories as $categorie) {
                $categorie->setDeleted(true);
                $this->entityManager->persist($categorie);
            }
        }
        else{
            return $this->json(["message"=>"error"]);
        }
        $this->entityManager->flush();
        return $this->json(["message"=>"success","nb"=>count($categories)]);
    }

    //TODO: review role/access control for writers
    //TODO: Blog table add needed fields

}
