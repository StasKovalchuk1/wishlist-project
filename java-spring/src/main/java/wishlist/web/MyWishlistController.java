package wishlist.web;

import javax.validation.Valid;
import lombok.Value;
import lombok.extern.slf4j.Slf4j;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.Errors;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import wishlist.Wish;
import wishlist.data.WishRepository;

import java.util.List;

@Controller
@RequestMapping("/mywishlist")
@Slf4j
public class MyWishlistController {

    private WishRepository wishRepository;

    @Autowired
    public MyWishlistController(WishRepository wishRepository){
        this.wishRepository = wishRepository;
    }

    @ModelAttribute(name = "wish")
    public Wish wish() { return new Wish(); }

    @ModelAttribute
    public void getWishes(Model model) {
        List<Wish> allWishes = (List<Wish>) wishRepository.findAll();
        model.addAttribute("wishes", allWishes);
    }

    @GetMapping
    public String showMyWishlist() {
        return "mywishlist"; }

    @GetMapping("/add")
    public String showFormToAddItem() { return "additem"; }

    @PostMapping
    public String addItem(@Valid Wish wish, Errors errors) {
        if (errors.hasErrors()){
            System.out.println(errors);
            return "redirect:/mywishlist/add";
        }

        wishRepository.save(wish);
        return "redirect:/mywishlist";
    }
}
